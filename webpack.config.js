const path = require('path');
const webpack = require('webpack');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FriendlyErrorsPlugin = require('friendly-errors-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

const extractSASS = new MiniCssExtractPlugin({
    path: path.resolve(__dirname, './public/dist/'),
    publicPath: './dist/',
    filename: '[name].style.css',
    chunkFilename: "[id].css",
    ignoreOrder: false
});

console.log(process.env.NODE_ENV);
module.exports = {
    mode: process.env.NODE_ENV,
    entry: {
        home: './src/home/main.js',
        customer: './src/customer/main.js',
    },
    output: {
        path: path.resolve(__dirname, './public/dist/'),
        publicPath: './dist/',
        filename: "[name].entry.js",
    },
    module: {
        rules: [
            {
                test: /\.(css|sass|scss)$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            minimize: false,
                            importLoaders: 1
                        }
                    },
                    {loader: 'resolve-url-loader'},
                    {loader: 'sass-loader'}
                ]
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
                test: /\.(png|jpg|gif|svg)$/,
                loader: 'file-loader',
                options: {
                    name: 'img/[name].[hash:7].[ext]',
                    path: '../../',
                    publicPath: './dist/',
                    limit: 1000,
                    emitFile: true
                }
            },
            {
                test: /\.(mp4|webm|ogg|mp3|wav|flac|aac)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                    limit: 1000,
                    path: '../../',
                    publicPath: './dist/',
                    name: 'video/[name].[hash:7].[ext]',
                }
            },
            {
                test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
                loader: 'file-loader',
                options: {
                    limit: 1000,
                    path: '../../',
                    publicPath: './dist/',
                    name: 'font/[name].[hash:7].[ext]',
                }
            }
        ],
        // noParse: function(content) {
        //     return /jquery|lodash/.test(content)
        // }
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
        new FriendlyErrorsPlugin(),
        new CleanWebpackPlugin(['public/dist']),
        extractSASS
    ],

    performance: {
        hints: false
    },

    optimization: {}

    // optimization: {
    //     splitChunks: {
    //         cacheGroups: {
    //             commons: {
    //                 name: "common",
    //                 chunks: "initial",
    //                 minChunks: 2,
    //                 maxInitialRequests: 5, // The default limit is too small to showcase the effect
    //                 minSize: 0 // This is example is too small to create commons chunks,
    //             },
    //             vendor: {
    //                 test: /node_modules/,
    //                 chunks: "initial",
    //                 name: "vendor",
    //                 priority: 10,
    //                 enforce: true
    //             },
    //             styles: {
    //                 name: 'styles',
    //                 test: /\.css$/,
    //                 chunks: 'all',
    //                 enforce: true
    //             }
    //         }
    //     }
    // }
};

if (process.env.NODE_ENV === 'development') {
    const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
    const LiveReloadPlugin = require('webpack-livereload-plugin');
    const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

    module.exports.devServer = {
        historyApiFallback: true,
        noInfo: false,
        overlay: true,
        contentBase: false,
        hot: true,
        publicPath: '/dist/',
        headers: {
            'Access-Control-Allow-Origin': '*'
        }
    };
    module.exports.devtool = '#eval-source-map';

    module.exports.plugins = (module.exports.plugins || []).concat([
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
                reload: true
            }),
        new BundleAnalyzerPlugin()
    ]);
} else if (process.env.NODE_ENV === 'production') {
    module.exports.devtool = '#source-map';
    // http://vue-loader.vuejs.org/en/workflow/production.html
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.LoaderOptionsPlugin({
            minimize: true
        }),
        new UglifyJsPlugin({
            sourceMap: false,
            uglifyOptions: {
                output: {
                    ie8: true,
                    ecma: 6,
                    comments: false
                },
                compress: {
                    warnings: false,
                }
            }
        })
    ]);

    module.exports.optimization ={
        minimize: true,
        minimizer: [
            new OptimizeCSSAssetsPlugin({})
        ],
    };
}
