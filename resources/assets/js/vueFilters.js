Vue.filter('getLanguageNameById', function (languages, lang_id) {
    return languages.find( lang => { 
        return lang.id === lang_id
    })
});

Vue.filter('extractLanguageName', function (language) {
    return language.name
});