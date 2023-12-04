function getGlobal() {
  if (typeof self !== 'undefined') {
    return self;
  }
  if (typeof window !== 'undefined') {
    return window;
  }
  if (typeof global !== 'undefined') {
    return global;
  }
  return {};
}

module.exports = function getGlobalVault() {
  const g = getGlobal();

  // Found a vault.
  if (typeof g['IIIF_VAULT'] !== 'undefined') {
    return g['IIIF_VAULT'];
  }

  if (typeof g.IIIFVault === 'undefined') {
    throw new Error('Vault not found');
  }

  g['IIIF_VAULT'] = new g.IIIFVault.Vault();

  return g['IIIF_VAULT'];
};
