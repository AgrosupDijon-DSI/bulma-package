import SlimSelect, {Settings} from 'slim-select'

const labels = {
  fr: {
    searchText: 'Aucun résultat',
    searchPlaceholder: 'Rechercher...',
    maxValuesMessage: '{number} options sélectionnées',
  },
};

const lang = document.querySelector('html').getAttribute("lang") || 'en_US';
const langKey = lang.substr(0, 2);
const localizedLabels = labels[langKey];

document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('select[multiple]:not(.no-slim-select)') !== null) {
    document.querySelectorAll('select[multiple]:not(.no-slim-select)').forEach(selectMultipleElement => {

      const settings = new Settings({
        closeOnSelect: false,
        showSearch: false,
        hideSelected: true,
        ...localizedLabels
      });

      Object.entries(settings).forEach(([key, value]) => {
        if (selectMultipleElement.dataset[key]) {
          const propertyType = typeof value
          switch (propertyType) {
            case "boolean":
              settings[key] = selectMultipleElement.dataset[key] === "true" ? true : false;
              break;
            case "number":
              settings[key] = parseFloat(selectMultipleElement.dataset[key]);
              break;
            default:
              settings[key] = selectMultipleElement.dataset[key]
          }
        }
      });

      new SlimSelect({
        select: selectMultipleElement,
        settings: settings
      });
    });
  }
});
