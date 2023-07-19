// language.js
$(document).ready(function () {
    // Fonction pour charger les traductions
    function loadTranslations(lang) {
      $.getJSON(`../lang/${lang}.json`, function (translations) {
        $('[data-translate]').each(function () {
          var key = $(this).data('translate');
          $(this).text(translations[key]);
        });
      });
    }
  
    // Fonction pour définir la langue par défaut en fonction de la langue de l'utilisateur
    function setUserLanguage() {
      var userLanguage = navigator.language || navigator.userLanguage;
      var languageCode = userLanguage.substring(0, 2); // Extraire les deux premiers caractères (ex: 'en', 'fr')
      var supportedLanguages = ['en', 'fr'];
  
      if (supportedLanguages.includes(languageCode)) {
        loadTranslations(languageCode);
      } else {
        // Si la langue de l'utilisateur n'est pas prise en charge, définir une langue par défaut (ici, l'anglais)
        var defaultLanguage = 'en';
        loadTranslations(defaultLanguage);
      }
    }
  
    // Gestionnaires d'événements pour les options de langue
    $('#language-en').on('click', function () {
      loadTranslations('en');
    });
  
    $('#language-fr').on('click', function () {
      loadTranslations('fr');
    });
  
    // Définir la langue de l'utilisateur au démarrage de la page
    setUserLanguage();
  });