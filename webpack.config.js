const path = require('path');
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const {CleanWebpackPlugin} = require("clean-webpack-plugin");

module.exports = {
    entry: './frontend/web/js/main.js',
    output: {
        chunkFilename: '[name].[contenthash].js',
        path: path.resolve(__dirname, 'frontend/web/js/dist'),
        publicPath: '/js/dist/',
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
                // Always use MiniCssExtractPlugin.loader to generate a final CSS file,
                // which you can then include via an Asset Bundle in Yii2.
                test: /\.s[ac]ss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.css$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                ],
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                type: 'asset/resource',
                generator: {
                    filename: '[name][ext]',
                    publicPath: '/fonts/'
                },
            },
        ],
    },
    optimization: {
        minimize: true,
        minimizer: [new TerserPlugin()],
    },
    resolve: {
        alias: {
            '@modules': path.resolve(__dirname, 'frontend/web/js/modules/'),
            '@widgets': path.resolve(__dirname, 'frontend/web/js/widgets/'),
            '@utils': path.resolve(__dirname, 'frontend/web/js/utils/'),
            '@urls': path.resolve(__dirname, 'frontend/web/js/urls/'),
            '@styles': path.resolve(__dirname, 'frontend/web/css'),
            '@fonts': path.resolve(__dirname, 'common/web/fonts')
        },
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'main.css'
        }),
        new CleanWebpackPlugin(),
    ],
};