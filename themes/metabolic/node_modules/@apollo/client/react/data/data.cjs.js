'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

var tslib = require('tslib');
var equality = require('@wry/equality');
var tsInvariant = require('ts-invariant');
var parser = require('../parser');
var errors = require('../../errors');
var core = require('../../core');

var OperationData = (function () {
    function OperationData(options, context) {
        this.isMounted = false;
        this.previousOptions = {};
        this.context = {};
        this.options = {};
        this.options = options || {};
        this.context = context || {};
    }
    OperationData.prototype.getOptions = function () {
        return this.options;
    };
    OperationData.prototype.setOptions = function (newOptions, storePrevious) {
        if (storePrevious === void 0) { storePrevious = false; }
        if (storePrevious && !equality.equal(this.options, newOptions)) {
            this.previousOptions = this.options;
        }
        this.options = newOptions;
    };
    OperationData.prototype.unmount = function () {
        this.isMounted = false;
    };
    OperationData.prototype.refreshClient = function () {
        var client = (this.options && this.options.client) ||
            (this.context && this.context.client);
        process.env.NODE_ENV === "production" ? tsInvariant.invariant(!!client, 29) : tsInvariant.invariant(!!client, 'Could not find "client" in the context or passed in as an option. ' +
            'Wrap the root component in an <ApolloProvider>, or pass an ' +
            'ApolloClient instance in via options.');
        var isNew = false;
        if (client !== this.client) {
            isNew = true;
            this.client = client;
            this.cleanup();
        }
        return {
            client: this.client,
            isNew: isNew
        };
    };
    OperationData.prototype.verifyDocumentType = function (document, type) {
        var operation = parser.parser(document);
        var requiredOperationName = parser.operationName(type);
        var usedOperationName = parser.operationName(operation.type);
        process.env.NODE_ENV === "production" ? tsInvariant.invariant(operation.type === type, 30) : tsInvariant.invariant(operation.type === type, "Running a " + requiredOperationName + " requires a graphql " +
            (requiredOperationName + ", but a " + usedOperationName + " was used instead."));
    };
    return OperationData;
}());

var SubscriptionData = (function (_super) {
    tslib.__extends(SubscriptionData, _super);
    function SubscriptionData(_a) {
        var options = _a.options, context = _a.context, setResult = _a.setResult;
        var _this = _super.call(this, options, context) || this;
        _this.currentObservable = {};
        _this.setResult = setResult;
        _this.initialize(options);
        return _this;
    }
    SubscriptionData.prototype.execute = function (result) {
        if (this.getOptions().skip === true) {
            this.cleanup();
            return {
                loading: false,
                error: undefined,
                data: undefined,
                variables: this.getOptions().variables
            };
        }
        var currentResult = result;
        if (this.refreshClient().isNew) {
            currentResult = this.getLoadingResult();
        }
        var shouldResubscribe = this.getOptions().shouldResubscribe;
        if (typeof shouldResubscribe === 'function') {
            shouldResubscribe = !!shouldResubscribe(this.getOptions());
        }
        if (shouldResubscribe !== false &&
            this.previousOptions &&
            Object.keys(this.previousOptions).length > 0 &&
            (this.previousOptions.subscription !== this.getOptions().subscription ||
                !equality.equal(this.previousOptions.variables, this.getOptions().variables) ||
                this.previousOptions.skip !== this.getOptions().skip)) {
            this.cleanup();
            currentResult = this.getLoadingResult();
        }
        this.initialize(this.getOptions());
        this.startSubscription();
        this.previousOptions = this.getOptions();
        return tslib.__assign(tslib.__assign({}, currentResult), { variables: this.getOptions().variables });
    };
    SubscriptionData.prototype.afterExecute = function () {
        this.isMounted = true;
    };
    SubscriptionData.prototype.cleanup = function () {
        this.endSubscription();
        delete this.currentObservable.query;
    };
    SubscriptionData.prototype.initialize = function (options) {
        if (this.currentObservable.query || this.getOptions().skip === true)
            return;
        this.currentObservable.query = this.refreshClient().client.subscribe({
            query: options.subscription,
            variables: options.variables,
            fetchPolicy: options.fetchPolicy,
            context: options.context,
        });
    };
    SubscriptionData.prototype.startSubscription = function () {
        if (this.currentObservable.subscription)
            return;
        this.currentObservable.subscription = this.currentObservable.query.subscribe({
            next: this.updateCurrentData.bind(this),
            error: this.updateError.bind(this),
            complete: this.completeSubscription.bind(this)
        });
    };
    SubscriptionData.prototype.getLoadingResult = function () {
        return {
            loading: true,
            error: undefined,
            data: undefined
        };
    };
    SubscriptionData.prototype.updateResult = function (result) {
        if (this.isMounted) {
            this.setResult(result);
        }
    };
    SubscriptionData.prototype.updateCurrentData = function (result) {
        var onSubscriptionData = this.getOptions().onSubscriptionData;
        this.updateResult({
            data: result.data,
            loading: false,
            error: undefined
        });
        if (onSubscriptionData) {
            onSubscriptionData({
                client: this.refreshClient().client,
                subscriptionData: result
            });
        }
    };
    SubscriptionData.prototype.updateError = function (error) {
        this.updateResult({
            error: error,
            loading: false
        });
    };
    SubscriptionData.prototype.completeSubscription = function () {
        var _this = this;
        Promise.resolve().then(function () {
            var onSubscriptionComplete = _this.getOptions().onSubscriptionComplete;
            if (onSubscriptionComplete)
                onSubscriptionComplete();
            _this.endSubscription();
        });
    };
    SubscriptionData.prototype.endSubscription = function () {
        if (this.currentObservable.subscription) {
            this.currentObservable.subscription.unsubscribe();
            delete this.currentObservable.subscription;
        }
    };
    return SubscriptionData;
}(OperationData));

var MutationData = (function (_super) {
    tslib.__extends(MutationData, _super);
    function MutationData(_a) {
        var options = _a.options, context = _a.context, result = _a.result, setResult = _a.setResult;
        var _this = _super.call(this, options, context) || this;
        _this.runMutation = function (mutationFunctionOptions) {
            if (mutationFunctionOptions === void 0) { mutationFunctionOptions = {}; }
            _this.onMutationStart();
            var mutationId = _this.generateNewMutationId();
            return _this.mutate(mutationFunctionOptions)
                .then(function (response) {
                _this.onMutationCompleted(response, mutationId);
                return response;
            })
                .catch(function (error) {
                var onError = _this.getOptions().onError;
                _this.onMutationError(error, mutationId);
                if (onError) {
                    onError(error);
                    return {
                        data: undefined,
                        errors: error,
                    };
                }
                else {
                    throw error;
                }
            });
        };
        _this.verifyDocumentType(options.mutation, parser.DocumentType.Mutation);
        _this.result = result;
        _this.setResult = setResult;
        _this.mostRecentMutationId = 0;
        return _this;
    }
    MutationData.prototype.execute = function (result) {
        this.isMounted = true;
        this.verifyDocumentType(this.getOptions().mutation, parser.DocumentType.Mutation);
        return [
            this.runMutation,
            tslib.__assign(tslib.__assign({}, result), { client: this.refreshClient().client })
        ];
    };
    MutationData.prototype.afterExecute = function () {
        this.isMounted = true;
        return this.unmount.bind(this);
    };
    MutationData.prototype.cleanup = function () {
    };
    MutationData.prototype.mutate = function (options) {
        return this.refreshClient().client.mutate(core.mergeOptions(this.getOptions(), options));
    };
    MutationData.prototype.onMutationStart = function () {
        if (!this.result.loading && !this.getOptions().ignoreResults) {
            this.updateResult({
                loading: true,
                error: undefined,
                data: undefined,
                called: true
            });
        }
    };
    MutationData.prototype.onMutationCompleted = function (response, mutationId) {
        var _a = this.getOptions(), onCompleted = _a.onCompleted, ignoreResults = _a.ignoreResults;
        var data = response.data, errors$1 = response.errors;
        var error = errors$1 && errors$1.length > 0
            ? new errors.ApolloError({ graphQLErrors: errors$1 })
            : undefined;
        var callOncomplete = function () {
            return onCompleted ? onCompleted(data) : null;
        };
        if (this.isMostRecentMutation(mutationId) && !ignoreResults) {
            this.updateResult({
                called: true,
                loading: false,
                data: data,
                error: error
            });
        }
        callOncomplete();
    };
    MutationData.prototype.onMutationError = function (error, mutationId) {
        if (this.isMostRecentMutation(mutationId)) {
            this.updateResult({
                loading: false,
                error: error,
                data: undefined,
                called: true
            });
        }
    };
    MutationData.prototype.generateNewMutationId = function () {
        return ++this.mostRecentMutationId;
    };
    MutationData.prototype.isMostRecentMutation = function (mutationId) {
        return this.mostRecentMutationId === mutationId;
    };
    MutationData.prototype.updateResult = function (result) {
        if (this.isMounted &&
            (!this.previousResult || !equality.equal(this.previousResult, result))) {
            this.setResult(result);
            this.previousResult = result;
            return result;
        }
    };
    return MutationData;
}(OperationData));

var QueryData = (function (_super) {
    tslib.__extends(QueryData, _super);
    function QueryData(_a) {
        var options = _a.options, context = _a.context, onNewData = _a.onNewData;
        var _this = _super.call(this, options, context) || this;
        _this.runLazy = false;
        _this.previous = Object.create(null);
        _this.runLazyQuery = function (options) {
            _this.cleanup();
            _this.runLazy = true;
            _this.lazyOptions = options;
            _this.onNewData();
        };
        _this.getQueryResult = function () {
            var result = _this.observableQueryFields();
            var options = _this.getOptions();
            if (options.skip) {
                result = tslib.__assign(tslib.__assign({}, result), { data: undefined, error: undefined, loading: false, networkStatus: core.NetworkStatus.ready, called: true });
            }
            else if (_this.currentObservable) {
                var currentResult = _this.currentObservable.getCurrentResult();
                var data = currentResult.data, loading = currentResult.loading, partial = currentResult.partial, networkStatus = currentResult.networkStatus, errors$1 = currentResult.errors;
                var error = currentResult.error;
                if (errors$1 && errors$1.length > 0) {
                    error = new errors.ApolloError({ graphQLErrors: errors$1 });
                }
                result = tslib.__assign(tslib.__assign({}, result), { data: data,
                    loading: loading,
                    networkStatus: networkStatus,
                    error: error, called: true });
                if (loading) ;
                else if (error) {
                    Object.assign(result, {
                        data: (_this.currentObservable.getLastResult() || {})
                            .data
                    });
                }
                else {
                    var fetchPolicy = _this.currentObservable.options.fetchPolicy;
                    var partialRefetch = options.partialRefetch;
                    if (partialRefetch &&
                        partial &&
                        (!data || Object.keys(data).length === 0) &&
                        fetchPolicy !== 'cache-only') {
                        Object.assign(result, {
                            loading: true,
                            networkStatus: core.NetworkStatus.loading
                        });
                        result.refetch();
                        return result;
                    }
                }
            }
            result.client = _this.client;
            _this.setOptions(options, true);
            var previousResult = _this.previous.result;
            _this.previous.loading =
                previousResult && previousResult.loading || false;
            result.previousData = previousResult &&
                (previousResult.data || previousResult.previousData);
            _this.previous.result = result;
            _this.currentObservable && _this.currentObservable.resetQueryStoreErrors();
            return result;
        };
        _this.obsRefetch = function (variables) { var _a; return (_a = _this.currentObservable) === null || _a === void 0 ? void 0 : _a.refetch(variables); };
        _this.obsFetchMore = function (fetchMoreOptions) { return _this.currentObservable.fetchMore(fetchMoreOptions); };
        _this.obsUpdateQuery = function (mapFn) { return _this.currentObservable.updateQuery(mapFn); };
        _this.obsStartPolling = function (pollInterval) {
            var _a;
            (_a = _this.currentObservable) === null || _a === void 0 ? void 0 : _a.startPolling(pollInterval);
        };
        _this.obsStopPolling = function () {
            var _a;
            (_a = _this.currentObservable) === null || _a === void 0 ? void 0 : _a.stopPolling();
        };
        _this.obsSubscribeToMore = function (options) { return _this.currentObservable.subscribeToMore(options); };
        _this.onNewData = onNewData;
        return _this;
    }
    QueryData.prototype.execute = function () {
        this.refreshClient();
        var _a = this.getOptions(), skip = _a.skip, query = _a.query;
        if (skip || query !== this.previous.query) {
            this.removeQuerySubscription();
            this.removeObservable(!skip);
            this.previous.query = query;
        }
        this.updateObservableQuery();
        if (this.isMounted)
            this.startQuerySubscription();
        return this.getExecuteSsrResult() || this.getExecuteResult();
    };
    QueryData.prototype.executeLazy = function () {
        return !this.runLazy
            ? [
                this.runLazyQuery,
                {
                    loading: false,
                    networkStatus: core.NetworkStatus.ready,
                    called: false,
                    data: undefined
                }
            ]
            : [this.runLazyQuery, this.execute()];
    };
    QueryData.prototype.fetchData = function () {
        var _this = this;
        var options = this.getOptions();
        if (options.skip || options.ssr === false)
            return false;
        return new Promise(function (resolve) { return _this.startQuerySubscription(resolve); });
    };
    QueryData.prototype.afterExecute = function (_a) {
        var _b = (_a === void 0 ? {} : _a).lazy, lazy = _b === void 0 ? false : _b;
        this.isMounted = true;
        if (!lazy || this.runLazy) {
            this.handleErrorOrCompleted();
        }
        this.previousOptions = this.getOptions();
        return this.unmount.bind(this);
    };
    QueryData.prototype.cleanup = function () {
        this.removeQuerySubscription();
        this.removeObservable(true);
        delete this.previous.result;
    };
    QueryData.prototype.getOptions = function () {
        var options = _super.prototype.getOptions.call(this);
        if (this.lazyOptions) {
            options.variables = tslib.__assign(tslib.__assign({}, options.variables), this.lazyOptions.variables);
            options.context = tslib.__assign(tslib.__assign({}, options.context), this.lazyOptions.context);
        }
        if (this.runLazy) {
            delete options.skip;
        }
        return options;
    };
    QueryData.prototype.ssrInitiated = function () {
        return this.context && this.context.renderPromises;
    };
    QueryData.prototype.getExecuteResult = function () {
        var result = this.getQueryResult();
        this.startQuerySubscription();
        return result;
    };
    QueryData.prototype.getExecuteSsrResult = function () {
        var _a = this.getOptions(), ssr = _a.ssr, skip = _a.skip;
        var ssrDisabled = ssr === false;
        var fetchDisabled = this.refreshClient().client.disableNetworkFetches;
        var ssrLoading = tslib.__assign({ loading: true, networkStatus: core.NetworkStatus.loading, called: true, data: undefined, stale: false, client: this.client }, this.observableQueryFields());
        if (ssrDisabled && (this.ssrInitiated() || fetchDisabled)) {
            this.previous.result = ssrLoading;
            return ssrLoading;
        }
        if (this.ssrInitiated()) {
            var result = this.getQueryResult() || ssrLoading;
            if (result.loading && !skip) {
                this.context.renderPromises.addQueryPromise(this, function () { return null; });
            }
            return result;
        }
    };
    QueryData.prototype.prepareObservableQueryOptions = function () {
        var options = this.getOptions();
        this.verifyDocumentType(options.query, parser.DocumentType.Query);
        var displayName = options.displayName || 'Query';
        if (this.ssrInitiated() &&
            (options.fetchPolicy === 'network-only' ||
                options.fetchPolicy === 'cache-and-network')) {
            options.fetchPolicy = 'cache-first';
        }
        return tslib.__assign(tslib.__assign({}, options), { displayName: displayName, context: options.context });
    };
    QueryData.prototype.initializeObservableQuery = function () {
        if (this.ssrInitiated()) {
            this.currentObservable = this.context.renderPromises.getSSRObservable(this.getOptions());
        }
        if (!this.currentObservable) {
            var observableQueryOptions = this.prepareObservableQueryOptions();
            this.previous.observableQueryOptions = tslib.__assign(tslib.__assign({}, observableQueryOptions), { children: null });
            this.currentObservable = this.refreshClient().client.watchQuery(tslib.__assign({}, observableQueryOptions));
            if (this.ssrInitiated()) {
                this.context.renderPromises.registerSSRObservable(this.currentObservable, observableQueryOptions);
            }
        }
    };
    QueryData.prototype.updateObservableQuery = function () {
        if (!this.currentObservable) {
            this.initializeObservableQuery();
            return;
        }
        if (this.getOptions().skip)
            return;
        var newObservableQueryOptions = tslib.__assign(tslib.__assign({}, this.prepareObservableQueryOptions()), { children: null });
        if (!equality.equal(newObservableQueryOptions, this.previous.observableQueryOptions)) {
            this.previous.observableQueryOptions = newObservableQueryOptions;
            this.currentObservable
                .setOptions(newObservableQueryOptions)
                .catch(function () { });
        }
    };
    QueryData.prototype.startQuerySubscription = function (onNewData) {
        var _this = this;
        if (onNewData === void 0) { onNewData = this.onNewData; }
        if (this.currentSubscription || this.getOptions().skip)
            return;
        this.currentSubscription = this.currentObservable.subscribe({
            next: function (_a) {
                var loading = _a.loading, networkStatus = _a.networkStatus, data = _a.data;
                var previousResult = _this.previous.result;
                if (previousResult &&
                    previousResult.loading === loading &&
                    previousResult.networkStatus === networkStatus &&
                    equality.equal(previousResult.data, data)) {
                    return;
                }
                onNewData();
            },
            error: function (error) {
                _this.resubscribeToQuery();
                if (!error.hasOwnProperty('graphQLErrors'))
                    throw error;
                var previousResult = _this.previous.result;
                if ((previousResult && previousResult.loading) ||
                    !equality.equal(error, _this.previous.error)) {
                    _this.previous.error = error;
                    onNewData();
                }
            }
        });
    };
    QueryData.prototype.resubscribeToQuery = function () {
        this.removeQuerySubscription();
        var currentObservable = this.currentObservable;
        if (currentObservable) {
            var lastError = currentObservable.getLastError();
            var lastResult = currentObservable.getLastResult();
            currentObservable.resetLastResults();
            this.startQuerySubscription();
            Object.assign(currentObservable, {
                lastError: lastError,
                lastResult: lastResult
            });
        }
    };
    QueryData.prototype.handleErrorOrCompleted = function () {
        if (!this.currentObservable || !this.previous.result)
            return;
        var _a = this.previous.result, data = _a.data, loading = _a.loading, error = _a.error;
        if (!loading) {
            var _b = this.getOptions(), query = _b.query, variables = _b.variables, onCompleted = _b.onCompleted, onError = _b.onError, skip = _b.skip;
            if (this.previousOptions &&
                !this.previous.loading &&
                equality.equal(this.previousOptions.query, query) &&
                equality.equal(this.previousOptions.variables, variables)) {
                return;
            }
            if (onCompleted && !error && !skip) {
                onCompleted(data);
            }
            else if (onError && error) {
                onError(error);
            }
        }
    };
    QueryData.prototype.removeQuerySubscription = function () {
        if (this.currentSubscription) {
            this.currentSubscription.unsubscribe();
            delete this.currentSubscription;
        }
    };
    QueryData.prototype.removeObservable = function (andDelete) {
        if (this.currentObservable) {
            this.currentObservable["tearDownQuery"]();
            if (andDelete) {
                delete this.currentObservable;
            }
        }
    };
    QueryData.prototype.observableQueryFields = function () {
        var _a;
        return {
            variables: (_a = this.currentObservable) === null || _a === void 0 ? void 0 : _a.variables,
            refetch: this.obsRefetch,
            fetchMore: this.obsFetchMore,
            updateQuery: this.obsUpdateQuery,
            startPolling: this.obsStartPolling,
            stopPolling: this.obsStopPolling,
            subscribeToMore: this.obsSubscribeToMore
        };
    };
    return QueryData;
}(OperationData));

exports.MutationData = MutationData;
exports.OperationData = OperationData;
exports.QueryData = QueryData;
exports.SubscriptionData = SubscriptionData;
//# sourceMappingURL=data.cjs.js.map
