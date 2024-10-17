import SlimSelect from 'slim-select'

new SlimSelect({
    select: 'select[multiple=multiple]',
    settings: {
        closeOnSelect: false,
        showSearch: false,
        hideSelected: true,
        // placeholderText: 'Choisissez un ou plusieurs sujets'
    },
})
