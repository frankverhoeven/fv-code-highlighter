const path = require('path');
const webpack = require('webpack');
const inProduction = ('production' === process.env.NODE_ENV);

const config = {
    externals: {
        $: 'jQuery',
        jquery: 'jQuery',
        lodash: 'lodash',
        react: 'React',
    },
    devtool: 'source-map',
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loaders: [
                    'babel-loader',
                ],
            },
        ],
    },
    plugins: [],
};

module.exports = [
    Object.assign({
        entry: {
            gutenberg: ['./gutenberg/src/index.js'],
        },
        output: {
            path: path.join(__dirname, './public/js/'),
            filename: '[name].js',
            libraryTarget: 'umd',
        },
    }, config),
];

if (inProduction) {
    config.plugins.push(new webpack.optimize.UglifyJsPlugin({sourceMap: true}));
}
