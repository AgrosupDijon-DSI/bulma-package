const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('Resources/Public/Build/')
    // public path used by the web server to access the output path
    .setPublicPath('/Build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('bulma.accordion.min', './Resources/Public/JavaScript/bulma.accordion.js')
    .addEntry('bulma.burger.min', './Resources/Public/JavaScript/bulma.burger.js')
    .addEntry('bulma.cookieconsent.min', './Resources/Public/JavaScript/bulma.cookieconsent.js')
    .addEntry('bulma.dropdown.min', './Resources/Public/JavaScript/bulma.dropdown.js')
    .addEntry('bulma.flickity.min', './Resources/Public/JavaScript/bulma.flickity.js')
    .addEntry('bulma.form.min', './Resources/Public/JavaScript/bulma.form.js')
    .addEntry('bulma.lightbox.min', './Resources/Public/JavaScript/bulma.lightbox.js')
    .addEntry('bulma.news.min', './Resources/Public/JavaScript/bulma.news.js')
    .addEntry('bulma.scrolltop.min', './Resources/Public/JavaScript/bulma.scrolltop.js')
    .addEntry('shareon.min', './Resources/Public/JavaScript/shareon.js')
    .addEntry('simplebar.min', './Resources/Public/JavaScript/simplebar.js')
    .addEntry('slim-select.min', './Resources/Public/JavaScript/slim-select.js')

    .addStyleEntry('rte.min', './Resources/Public/Scss/Rte/rte.scss')

    .copyFiles([
        {from: './node_modules/bulma-scss', to: '../Contrib/bulma-scss/[path][name].[ext]'},

        {from: './node_modules/@vizuaalog/bulmajs/dist', to: '../Contrib/bulmajs/[path][name].[ext]', pattern: /tabs.js$/},
        {from: './node_modules/@vizuaalog/bulmajs', to: '../Contrib/bulmajs/[name]', includeSubdirectories: false, pattern: /LICENSE$/},

        // {from: './node_modules/@creativebulma/bulma-collapsible/dist/js', to: '../Contrib/bulma-collapsible/[name].[ext]'},
        {from: './node_modules/@creativebulma/bulma-collapsible', to: '../Contrib/bulma-collapsible/[name]', includeSubdirectories: false, pattern: /LICENSE$/},

        {from: './node_modules/flickity/dist', to: '../Contrib/flickity/[path][name].[ext]', pattern: /\.min.js$/},
        {from: './node_modules/flickity-fade', to: '../Contrib/flickity/[path][name].[ext]', includeSubdirectories: false, pattern: /\.js$/},

        {from: './node_modules/cookieconsent/build', to: '../Contrib/cookieconsent/[path][name].[ext]', pattern: /\.min.js$/},
        {from: './node_modules/cookieconsent', to: '../Contrib/cookieconsent/[name]', includeSubdirectories: false, pattern: /licence$/},

        {from: './node_modules/@fortawesome/fontawesome-free/css', to: `../Contrib/fontawesome-free/css/[path][name].[ext]`, pattern: /brands.min.css$/},
        {from: './node_modules/@fortawesome/fontawesome-free/css', to: `../Contrib/fontawesome-free/css/[path][name].[ext]`, pattern: /fontawesome.min.css$/},
        {from: './node_modules/@fortawesome/fontawesome-free/css', to: `../Contrib/fontawesome-free/css/[path][name].[ext]`, pattern: /regular.min.css$/},
        {from: './node_modules/@fortawesome/fontawesome-free/css', to: `../Contrib/fontawesome-free/css/[path][name].[ext]`, pattern: /solid.min.css$/},
        {from: './node_modules/@fortawesome/fontawesome-free/webfonts', to: `../Contrib/fontawesome-free/webfonts/[path][name].[ext]`},
        {from: './node_modules/@fortawesome/fontawesome-free', to: `../Contrib/fontawesome-free/[path][name].[ext]`, includeSubdirectories: false, pattern: /\.txt$/},
        {from: './node_modules/@fortawesome/fontawesome-free/svgs', to: `../Icons/FontAwesome/[path][name].[ext]`, pattern: /\.svg$/},

        {from: './node_modules/photoswipe/dist', to: '../Contrib/photoswipe/[path][name].[ext]', pattern: /\.min.js$/},
        {from: './node_modules/photoswipe', to: '../Contrib/photoswipe/[name]', includeSubdirectories: false, pattern: /LICENSE$/},

        {from: './node_modules/ionicons/dist/css', to: '../Contrib/ionicons/css/[path][name].[ext]', pattern: /ionicons.min.css$/},
        {from: './node_modules/ionicons/dist/fonts', to: '../Contrib/ionicons/fonts/[path][name].[ext]'},
        {from: './node_modules/ionicons', to: '../Contrib/ionicons/[path][name]', includeSubdirectories: false, pattern: /LICENSE$/},
        {from: './node_modules/ionicons/dist/ionicons/svg', to: '../Icons/Ionicons/[path][name].[ext]', includeSubdirectories: false, pattern: /\.svg$/},

        {from: './node_modules/slim-select/src/slim-select', to: `../Contrib/slim-select/[path][name].[ext]`, pattern: /\.scss$/},
    ])

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    // .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    // .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    // .enableSingleRuntimeChunk()
    .disableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild([
        '**/*',
        '../Contrib/**/*',
        '../Icons/FontAwesome/**/*',
        '../Icons/Ionicons/**/*',
    ],(options) => {
        options.dry = false;
        options.dangerouslyAllowCleanPatternsOutsideProject = true;
    })

    // .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use React
//.enableReactPreset()

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
//.enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
