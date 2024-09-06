import Polyglot from 'node-polyglot';
import TimeAgo from 'timeago-react';
import * as timeago from 'timeago.js';

import messages_ar from './messages_ar.json';
import messages_cs from './messages_cs.json';
import messages_de from './messages_de.json';
import messages_el from './messages_el.json';
import messages_es from './messages_es.json';
import messages_fi from './messages_fi.json';
import messages_fr from './messages_fr.json';
import messages_gl from './messages_gl.json';
import messages_hi from './messages_hi.json';
import messages_it from './messages_it.json';
import messages_ja from './messages_ja.json';
import messages_ko from './messages_ko.json';
import messages_nl from './messages_nl.json';
import messages_pt from './messages_pt.json';
import messages_ru from './messages_ru.json';
import messages_sv from './messages_sv.json';
import messages_th from './messages_th.json';
import messages_tr from './messages_tr.json';
import messages_ur from './messages_ur.json';
import messages_zh from './messages_zh.json';
import messages_zh_CN from './messages_zh_CN.json';
import messages_zh_TW from './messages_zh_TW.json';

const MESSAGES = {
  ar: messages_ar,
  cs: messages_cs,
  de: messages_de,
  el: messages_el,
  es: messages_es,
  fi: messages_fi,
  fr: messages_fr,
  gl: messages_gl,
  hi: messages_hi,
  it: messages_it,
  ja: messages_ja,
  ko: messages_ko,
  nl: messages_nl,
  pt: messages_pt,
  ru: messages_ru,
  sv: messages_sv,
  th: messages_th,
  tr: messages_tr,
  ur: messages_ur,
  zh: messages_zh,
  'zh-CN': messages_zh_CN,
  'zh-TW': messages_zh_TW
}

export const availableLocales = Object.keys(MESSAGES);

const i18n = new Polyglot({ allowMissing: true });

i18n.init = (lang, opt_messages) => {
  i18n.clear();

  if (lang) {
    i18n.locale(lang);
    i18n.extend(MESSAGES[lang]);
  }

  if (opt_messages)
    i18n.extend(opt_messages);
}

/** Load and register TimeAgo locales **/
import ar from 'timeago.js/lib/lang/ar';
import cs from 'timeago.js/lib/lang/cs';
import de from 'timeago.js/lib/lang/de';
import el from 'timeago.js/lib/lang/el';
import es from 'timeago.js/lib/lang/es';
import fi from 'timeago.js/lib/lang/fi';
import fr from 'timeago.js/lib/lang/fr';
import gl from 'timeago.js/lib/lang/gl';
import hi from 'timeago.js/lib/lang/hi_IN';
import it from 'timeago.js/lib/lang/it';
import ja from 'timeago.js/lib/lang/ja';
import ko from 'timeago.js/lib/lang/ko';
import nl from 'timeago.js/lib/lang/nl';
import pt from 'timeago.js/lib/lang/pt_BR';
import ru from 'timeago.js/lib/lang/ru';
import sv from 'timeago.js/lib/lang/sv';
import th from 'timeago.js/lib/lang/th';
import tr from 'timeago.js/lib/lang/tr';
// import ur from 'timeago.js/lib/lang/ur'; // Not currently supported by TimeAgo
import zh_CN from 'timeago.js/lib/lang/zh_CN';
import zh_TW from 'timeago.js/lib/lang/zh_TW';

timeago.register('ar', ar);
timeago.register('cs', cs);
timeago.register('de', de);
timeago.register('el', el);
timeago.register('es', es);
timeago.register('fi', fi);
timeago.register('fr', fr);
timeago.register('gl', gl);
timeago.register('hi', hi);
timeago.register('it', it);
timeago.register('ja', ja);
timeago.register('ko', ko);
timeago.register('nl', nl);
timeago.register('pt', pt);
timeago.register('ru', ru);
timeago.register('sv', sv);
timeago.register('th', th);
timeago.register('tr', tr);
timeago.register('zh', zh_CN);
timeago.register('zh-CN', zh_CN);
timeago.register('zh-TW', zh_TW);

/**
 * Helper function that allows plugins to register their
 * own additional I18N labels
 */
i18n.registerMessages = (lang, messages) => {
  if (MESSAGES[lang])
    MESSAGES[lang] = {...MESSAGES[lang], ...messages };
  else
    MESSAGES[lang] = messages;
}

export default i18n;

/**
 * For convenience: exposes a pre-localized TimeAgo widget,
 * for use in plugins
 */
export const LocalTimeAgo = props => {

  return (
    <TimeAgo
      datetime={props.timestamp}
      locale={i18n.locale()} />
  )

}
