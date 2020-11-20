# Introduction

`Bootstrap4` package allows you to write report using Twitter Bootstrap v4.1.3.

# Installation

## By downloading .zip file

1. [Download](https://www.koolreport.com/packages/bootstrap4)
2. Unzip the zip file
3. Copy the folder `bootstrap4` into `koolreport` folder so that look like below

```bash
koolreport
├── core
├── bootstrap4
```

## By composer

```
composer require koolreport/bootstrap4
```

# Usage

In order to add `Bootstrap4` theme into your report, you simply do:


```
class MyReport extends \koolreport\KoolReport
{
    use \koolreport\bootstrap4\Theme;
}
```

# Support

Please use our forum if you need support, by this way other people can benefit as well. If the support request need privacy, you may send email to us at __support@koolreport.com__.
