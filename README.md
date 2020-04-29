# WP View

TODO ...

This is a must-use plugin used via composer, plugin activation not required.

Logic and conventions inspired by Laravel and React.

## Usage

Call function as `frc_view($viewName, $data = [])`.

If you don't pass array as a second argument it will be assigned to array with key `children`.

Default root for searching view is themes `views` folder.

### Example

```php
<?= frc_view('components/app',
    frc_view('components/layout', [
        'main' => frc_view('components/blocks'),
        'footer' => frc_view('components/page-footer', [
            'shares' => false,
        ]),
    ])
); ?>
```

Rendered as:

```html
// views/components/app.php

<head>
...
</head>
<body>
    <header>...</header>
    <main>
        <?= $children; ?> // content of views/components/layout.php 
    </main>
    <footer>...</footer>
</body>
```

```html
// views/components/layout.php

<div>
    <?= $main; ?> // content of views/components/blocks.php
</div>
<div>
    <?= $footer; ?> // content of views/components/page-footer.php
</div>
```
