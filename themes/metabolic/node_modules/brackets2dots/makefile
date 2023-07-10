.PHONY: clean test

STANDALONE := brackets2dots
MOCHAFLAGS ?= --reporter spec

clean:
	@$(RM) -fr node_modules $(STANDALONE).js
	@$(RM) -fr npm-debug.log

$(STANDALONE).js: index.js
	@./node_modules/.bin/browserify --entry $< --outfile $@ --standalone $(STANDALONE) 

test: node_modules $(STANDALONE).js
	@./node_modules/.bin/mocha $(MOCHAFLAGS)

node_modules: package.json
	@npm prune
	@npm install

release: test $(STANDALONE).js
