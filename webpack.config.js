const path = require('path');

// объект конфигурации
module.exports = {
    entry: './frontend/web/js/main.js',
    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, 'frontend/web/js/dist'),
        // publicPath: '/js/dist/',
    },
    externals: {
        jquery: 'jQuery',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env'],
                    },
                },
            },
            {
                test: /\.scss$/,
                use: [
                    process.env.NODE_ENV !== 'production'
                        ? 'style-loader'
                        : MiniCssExtractPlugin.loader,

                    // 'postcss-loader', // Поддержка старых браузеров
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                type: 'asset/resource',
                generator: {
                    filename: '[name][ext]',
                    publicPath: '/fonts/'
                },
            }
        ],
    },
    optimization: {
        splitChunks: {
            chunks: 'all',
        },
    },
    resolve: {
        alias: {
            '@styles': path.resolve(__dirname, 'frontend/web/css'),

            '@fonts': path.resolve(__dirname, 'common/web/fonts')
        },
    },
    // npm install --save-dev mini-css-extract-plugin
    // plugins: [
    //     new MiniCssExtractPlugin({
    //         filename: '[name].[contenthash].css',
    //     }),
    // ],
    // devServer: {
    //     contentBase: path.resolve(__dirname, 'web'),
    //     compress: true,
    //     port: 9000,
    //     hot: true,
    //     open: true,
    // },
};