# SideKit UI PHP core 
[![Build Status](https://img.shields.io/travis/sidekit-ui/sidekit-php-core/master.svg?style=flat-square)](https://travis-ci.org/sidekit-ui/sidekit-php-core)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sidekit-ui/sidekit-php-core/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sidekit-ui/sidekit-php-core/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/sidekit-ui/sidekit-php-core/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sidekit-ui/sidekit-php-core/?branch=master)

This is the foundation library to create PHP widget wrappers for the javascript sidekit-ui collected plugins. 

## Introduction 

SideKit UI was built with one thing in mind: to help backend developers to create cleaner code. There are many widgets 
and wrapper libraries out there fully bloated with Javascript and/or HTML tags within their PHP, #C, Java, etc... code 
in order to render the HTML syntax and the Javascript configuration code for a plugin to work. And that is not only 
ugly, hard to maintain, scale or whatever... but also, you end up breaking separation of concerns at all time, making 
silly workarounds to be able to have some type hinting abilities in your IDE that doesn't really know whether you are 
writing in one language or another.
 
We know it, because we are highly experienced on that matter and we made that mistake many times. 

From that experience, we believe:

- Javascript should be written in Javascript files and let the frontend development handle that part.
- Javascript libraries should be managed by their very own package managers and **NOT** a PHP package manager. 
- Javascript, HTML enhancements (ie uglify, minify, concatenate, jshinted) should be let to the frontend task/bundle 
  managers.
- Javascript testing should be written by Javascript testing libraries.
- Backend code should never, ever write Javascript registration of libraries and initialization code in their context.
- Backend code should avoid handling widget's template rendering. That is lame knowing all the powerful templating tools 
  that Javascript has nowadays.  

We are sure that many people out there do not agree with the above statements but let us give you a small example taken 
by one of our previous libraries:

```php 
public function registerClientScript()
{
    $js = [];
    $view = $this->getView();
    // @codeCoverageIgnoreStart
    if ($this->language !== null) {
        $this->clientOptions['language'] = $this->language;
        DatePickerLanguageAsset::register($view)->js[] = 'bootstrap-datepicker.' . $this->language . '.min.js';
    } else {
        DatePickerAsset::register($view);
    }
    // @codeCoverageIgnoreEnd
    $id = $this->options['id'];
    $selector = ";jQuery('#$id')";
    if ($this->addon || $this->inline) {
        $selector .= ".parent()";
    }
    $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';
    if ($this->inline) {
        $this->clientEvents['changeDate'] = "function (e){ jQuery('#$id').val(e.format());}";
    }
    $js[] = "$selector.datepicker($options);";
    if (!empty($this->clientEvents)) {
        foreach ($this->clientEvents as $event => $handler) {
            $js[] = "$selector.on('$event', $handler);";
        }
    }
    $view->registerJs(implode("\n", $js));
}
```

The above code is a common practice when building a Yii2 widget and I could show you even more horrible code from very 
popular Yii2 plugin wrappers out there. That in our opinion is a very bad practice, and proves the previous 
statements. 

Now, let me show you what SideKit UI PHP proposes: 

```php 
public function run()
{
    $data = [
        // This is the data for the frontend template 
        'data' => ['items' => $this->items],
        // This is the configuration options of the plugin
        'options' => $this->options
    ];

    return $this->renderTag('div', 'lightgallery', $data);
}
```

The code would render an HTML tag (the container), with an internal script with a global variable that has the 
information that its correspondent plugin understands to `render` and `initialize`. PHP code free of that gibberish.

For information on how to create a client plugin, please visit 
[sidekit-core client library](https://github.com/sidekit-ui/sidekit-core)


## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require sidekit-ui/sidekit-php-core
```

or add

```
"sidekit-ui/sidekit-php-core": "^1.0"
```

to the `require` section of your `composer.json` file.

## Usage 

The following is an example of PHP widget for the sidekit-php using its base classes and lightbox: 

```php
use SideKit\Base\AbstractWidget;
use SideKit\Exception\InvalidConfigurationException;

class LightGallery extends AbstractWidget
{
    /**
     * @var array the items to be rendered on the client side.
     */
    private $items = [];

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (empty($this->items)) {
            throw new InvalidConfigurationException("The 'items' options cannot be empty.");
        }
        parent::init();
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $data = [
            'data' => ['items' => $this->items],
            'options' => $this->options
        ];

        return $this->renderTag('div', 'lightgallery', $data);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->run();
    }
}
``` 

Assuming you have jquery + lightgallery.js plugin and the following client plugin on the client 
`sidekit.widget.lightgallery.js` inserted as script after `sidekit-ui-core.js` -you know we can concatenate them on 
production right?: 

```js 
(function (SideKit) {
    var cdnCss = '//cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.21/css/lightgallery.min.css',
        cdnJs = '//cdnjs.cloudflare.com/ajax/libs/lightgallery/1.2.21/js/lightgallery-all.min.js';

    SideKit.factory['lightgallery'] = $.extend({}, SideKit.widget, {
        init: function () {
            var path = this.getAssetsPath(),
                d = $.Deferred(),
                css = path === 'cdnJs' ? cdnCss : path + '/lightgallery/dist/css/lightgallery.min.css',
                js = path === 'cdnJs' ? cdnJs : path + '/lightgallery/dist/js/lightgallery-all.min.js';

            if (!$.fn.lightGallery) {
                $.when(
                    this.getStyleSheet(css),
                    $.getScript(js)
                ).then(function () {
                    d.resolve(true);
                });
            } else {
                d.resolve(true);
            }
            return d.promise();
        },
        run: function (id, data) {
            var $el = $('#' + id);
            this.render($el, data.data);
            $el.lightGallery(data.options);
        },
        template: function () {
            return ['{{#items}}',
                '<a href="{{ url }}">',
                '<img src="{{ img }}">',
                '</a>',
                '{{/items}}'
            ].join("\n");
        }
    });
})(SideKit);

```

We are ready to use it on our PHP code: 

```php 
<?= LightGallery::render(
    [
        'attributes' => [
            'id' => 'gallery' // if not provided, SideKit will assign one
        ],
        'items' => [
            [
                'url' => 'http://sachinchoolur.github.io/lightGallery/static/img/1.jpg',
                'options' => ['class' => 'img-responsive'],
                'img' => 'http://sachinchoolur.github.io/lightGallery/static/img/thumb-16.jpg'
            ],
            [
                'url' => 'http://sachinchoolur.github.io/lightGallery/static/img/2.jpg',
                'options' => ['class' => 'img-responsive'],
                'img' => 'http://sachinchoolur.github.io/lightGallery/static/img/thumb-17.jpg'
            ]
        ],
        // this is for the client plugin configuration
        'options' => [
            'thumbnail'
        ]
    ]
) ?>

<?php 
// or 

$lg = new LightGallery([ ... required configuration here ... ]);
$lg->attributes = ['id' => 'gallery'];
$lg->options = ['thumbnail'];

echo LightGallery;

?>

```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Clean code
 
We have added some development tools for you to contribute to the library with clean code: 

- PHP mess detector: Takes a given PHP source code base and look for several potential problems within that source.
- PHP code sniffer: Tokenizes PHP, JavaScript and CSS files and detects violations of a defined set of coding standards.
- PHP code fixer: Analyzes some PHP source code and tries to fix coding standards issues.

And you should use them in that order. 

### Using php mess detector

Sample with all options available:

```bash 
 ./vendor/bin/phpmd ./src text codesize,unusedcode,naming,design,controversial,cleancode
```

### Using code sniffer
 
```bash 
 ./vendor/bin/phpcs -s --report=source --standard=PSR2 ./src
```

### Using code fixer

We have added a PHP code fixer to standardize our code. It includes Symfony, PSR2 and some contributors rules. 

```bash 
./vendor/bin/php-cs-fixer --config-file=.php_cs fix ./src
```

## Testing

 ```bash
 $ ./vendor/bin/phpunit
 ```


## Credits

- [Antonio Ramirez](https://github.com/tonydspaniard)
- [All Contributors](https://github.com/sidekit-ui/sidekit-php-core/graphs/contributors)

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.

<blockquote>
    <a href="http://www.2amigos.us"><img src="http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png"></a><br>
    <i>web development has never been so fun</i><br> 
    <a href="http://www.2amigos.us">www.2amigos.us</a>
</blockquote>
