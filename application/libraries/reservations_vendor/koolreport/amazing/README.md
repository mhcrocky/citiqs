# Introduction

## Overview

`Amazing` is a theme for KoolReport. The theme is constructed on top of well-known modern Bootstrap 4 so it inherits all the features of the bootstrap.

## Installation

#### By downloading .zip file

1. Download zip file from [My Licenses](https://www.koolreport.com/my-licensed-packages)
2. Unzip
3. Copy the folder `amazing` into `koolreport` folder, it will look like below:

```bash
koolreport
├── core
├── amazing
```

#### By composer

If you have purchased the package then you can follow these steps to install

1. Login to [koolreport.com](https://www.koolreport.com)
2. Go to [My Licenses](https://www.koolreport.com/my-licensed-packages)
3. Click __Get Token For Composer__ button
4. Copy the text and save to file `auth.json` next to `composer.json`
5. Add the repositories to `composer.json` like below
6. Run `composer update` to install package

`composer.json`

```
{
    "repositories":[
      {"type":"composer","url":"https://repo.koolreport.com"}
    ],
    "require":{
        "koolreport/amazing":"*",
        ...
    }
}
```


Your `auth.json` will look like this:

```
{
    "http-basic": {
        "repo.koolreport.com": {
            "username": "your@email.com",
            "password": "your-secret-token"
        }
    }
}
```

__*Note:*__ Please add your `auth.json` to `.gitignore` as it contains your secret login information.


## Basic usage

In order to use the theme for a report, you register the following service inside your report class:

```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\amazing\Theme; //This line will add the theme to your report view
    ...
}
```

After adding the theme, you may notice the changes in font styles, chart color, buttons and so on.

## More documentation

Please visit our [documentation](https://www.koolreport.com/docs/amazing/overview/)

## Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.