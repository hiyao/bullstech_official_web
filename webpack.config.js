let path = require('path');
let webpack = require('webpack');
let BrowserSyncPlugin = require('browser-sync-webpack-plugin');
let LiveReloadPlugin = require('webpack-livereload-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');

module.exports = {
    mode: process.env.NODE_ENV,
    entry: {
        home: './src/home/main.js',
        customer: './src/customer/main.js'
    },
    output: {
        path: path.resolve(__dirname, './public/dist/'),
        publicPath: './dist/',
        filename: '[name].entry.js'
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ],
            },
            {
                test: /\.vue$/,
                exclude: /bower_components/,
                loader: 'vue-loader',
                options: {
                    loaders: {}
                    // other vue-loader options go here
                }
            },
            {
                test: /\.js$/,
                include: [ // use `include` vs `exclude` to white-list vs black-list
                    path.resolve(__dirname, "src"), // white-list your app source files
                    require.resolve("bootstrap-vue"), // white-list bootstrap-vue
                ],
                loader: 'babel-loader',
                exclude: /node_modules/
            },
            {
                test: /\.scss$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader'
                ]
            },
            {
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: '[path][name].[ext]?[hash]',
                }
            },
            {
                test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 100000,
                    name: '[path][name].[hash:7].[ext]',
                }
            },
            {
                test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 100000,
                    name: '[path][name].[hash:7].[ext]',
                }
            }
        ]
    },
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.esm.js',
            '@home': path.resolve(__dirname, './src/home'),
            '@': path.resolve(__dirname, './src/customer'),
        },
        extensions: ['*', '.js', '.vue', '.json']
    },

    plugins: [
        new LiveReloadPlugin(
            {
                appendScriptTag: true
            }),
        new BrowserSyncPlugin(
            {
                host: 'localhost',
                port: 3000,
                proxy: 'http://localhost:8080/'
            },
            {
                reload: false
            }),
        new CleanWebpackPlugin(['dist'])
    ],

    devServer: {
        historyApiFallback: true,
        noInfo: true,
        overlay: true,
        contentBase: false,
        hot: true,
        headers: {
            'Access-Control-Allow-Origin': '*'
        }
    },
    performance: {
        hints: false
    },
    devtool: '#eval-source-map'
};

if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map';
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ])
}
