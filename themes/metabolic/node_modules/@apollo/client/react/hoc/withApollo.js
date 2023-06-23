import { __assign, __extends } from "tslib";
import React from 'react';
import hoistNonReactStatics from 'hoist-non-react-statics';
import { invariant } from 'ts-invariant';
import { ApolloConsumer } from "../context/index.js";
function getDisplayName(WrappedComponent) {
    return WrappedComponent.displayName || WrappedComponent.name || 'Component';
}
export function withApollo(WrappedComponent, operationOptions) {
    if (operationOptions === void 0) { operationOptions = {}; }
    var withDisplayName = "withApollo(" + getDisplayName(WrappedComponent) + ")";
    var WithApollo = (function (_super) {
        __extends(WithApollo, _super);
        function WithApollo(props) {
            var _this = _super.call(this, props) || this;
            _this.setWrappedInstance = _this.setWrappedInstance.bind(_this);
            return _this;
        }
        WithApollo.prototype.getWrappedInstance = function () {
            process.env.NODE_ENV === "production" ? invariant(operationOptions.withRef, 32) : invariant(operationOptions.withRef, "To access the wrapped instance, you need to specify " +
                "{ withRef: true } in the options");
            return this.wrappedInstance;
        };
        WithApollo.prototype.setWrappedInstance = function (ref) {
            this.wrappedInstance = ref;
        };
        WithApollo.prototype.render = function () {
            var _this = this;
            return (React.createElement(ApolloConsumer, null, function (client) {
                var props = Object.assign({}, _this.props, {
                    client: client,
                    ref: operationOptions.withRef
                        ? _this.setWrappedInstance
                        : undefined
                });
                return React.createElement(WrappedComponent, __assign({}, props));
            }));
        };
        WithApollo.displayName = withDisplayName;
        WithApollo.WrappedComponent = WrappedComponent;
        return WithApollo;
    }(React.Component));
    return hoistNonReactStatics(WithApollo, WrappedComponent, {});
}
//# sourceMappingURL=withApollo.js.map