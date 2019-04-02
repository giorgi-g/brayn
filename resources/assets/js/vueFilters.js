window.Vue.filter('getLanguageNameById', function(languages, lang_id) {
  return languages.find(lang => {
    return lang.id === lang_id
  })
})

window.Vue.filter('extractLanguageName', function(language) {
  return language.name
})
