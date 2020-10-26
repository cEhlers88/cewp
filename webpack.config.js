/**
 * Library webpack.config
 *
 * @author Christoph Ehlers <ce@construktiv.de> | Construktiv GmbH
 */
const path = require('path');
const glob = require("glob");
// ...
const modulesEntries = (()=>{
    let result = {};
    ['frontend','backend'].map((enviroment)=>{
        ['ts','js','scss'].map((ext)=>{
            ['./modules/*/assets/'+enviroment+'.'+ext,].map((pattern)=>{
                const found = glob.sync(pattern);
                const startIndex = 10;
                found.map((item)=>{
                    const startSubString = item.substring(startIndex);
                    const moduleName = startSubString.substring(0,startSubString.indexOf('/'))+'_'+enviroment;
                    if(!result[moduleName]){result[moduleName] = [];}
                    result[moduleName].push(item);
                });
            });
        });
    });

    return result;
})()

const entry = {
    backend: [
        './assets/ts/backend.ts',
        './assets/scss/backend.scss'
    ],
    frontend:[
        './assets/ts/frontend.ts',
        './assets/scss/frontend.scss'
    ],
    ...modulesEntries
};

module.exports = {
    entry,
    output: {
        filename: (arg)=>{
            if(arg.chunk.name === 'backend' || arg.chunk.name === 'frontend'){
                return 'js/[name].js';
            }
            const split = arg.chunk.name.split('_');
            return 'js/'+split[0]+'/'+split[1]+'.js';
        },
        path: path.resolve(__dirname, 'dist')
    },
    module: {
        rules: [
            {
                test: /\.m?js/,
                resolve: {
                    fullySpecified: false,
                },
            },
            {
                test: /\.(j|t)sx?$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            cacheDirectory: true,
                        },
                    },
                ],
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: 'css/',
                            name: (path)=>{
                                const subFolder = path.substr(__dirname.length+1);
                                if(subFolder.substr(0,1) === 'a'){
                                    return '[name].css';
                                }
                                let moduleName = subFolder.substr(8);
                                moduleName = moduleName.substring(0,moduleName.indexOf('/'));
                                return moduleName+'/[name].css';
                            }
                        }
                    },
                    'sass-loader'
                ]
            }
        ]
    },
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.jsx']
    }
};