import SlimSelect from 'slim-select'

document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('select[multiple]') !== null ) {
        document.querySelectorAll('select[multiple]').forEach(selectMultipleElement => {
            new SlimSelect({
                select: selectMultipleElement,
                settings: {
                    closeOnSelect: false,
                    showSearch: false,
                    hideSelected: true,
                }
            })
        });
    }
});
