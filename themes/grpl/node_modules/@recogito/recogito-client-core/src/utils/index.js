import I18n, { availableLocales } from '../i18n';

/**
 * Helper to init the i18n class with a pre-defined or auto-detected locale.
 */
export const setLocale = (locale, opt_messages) => {
  if (locale) {
    const l = locale === 'auto' ?
      window.navigator.userLanguage || window.navigator.language : locale;

    const fallback = l.split('-')[0].toLowerCase();
    const foundLocale = [l, fallback].find(_l => availableLocales.includes(_l));

    if (!foundLocale) {
      console.warn(`Unsupported locale '${l}'. Falling back to default en.`);
    }

    I18n.init(foundLocale, opt_messages);
  } else {
    I18n.init(null, opt_messages);
  }
}
