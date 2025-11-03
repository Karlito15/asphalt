# jquery-backToTop

Fully customizable jQuery back to top button.

## Setup

Include both ``` jquery-backToTop.min.js ``` and ``` jquery-backToTop.min.css ``` in your document after including jQuery.

```html
<script src="jquery-backToTop.min.js"></script>
<link href="jquery-backToTop.min.css" type="text/css" rel="stylesheet" media="screen">
```

Note: Some themes use **font-awesome** theme [https://fontawesome.com/get-started].

## Usage

```javascript
var $button = $.backToTop({options});
```

### Options

| Option | Type | Default | Description |
| :-:|:-:|:-:|:--|
| backgroundColor | string | "#5D5D5D" | Background color of the backToTop |
| color | string | "#FFFFFF" | Text color |
| container | jQuery | $("body") | Container selector |
| **effect** | string | "spin" | Show/Hide effect |
| enabled | boolean | true | BackToTop enabled |
| height | number | 70 | Height of the button (px) |
| icon | string | "fas fa-chevron-up" | Font-awesome icon |
| marginX | number | 20 | Left/right margin (px) |
| marginY | number | 20 | Bottom/top margin (px) |
| position | string | "right" | Float position, left/right top/bottom, ex: "bottom right" |
| pxToTrigger | number | 600 | Scroll px to trigger |
| right | number | 20 | Right margin (px) when divFloat=*right* |
| scrollAnimation | number | 0 | Scroll animation |
| **theme** | string | "default" | Theme of the button |
| width | number | 70 | Width of the button |
| zIndex | number | 999 | z-Index of the button |

### Avaiable themes

- default
- fawesome

### Avaiable effects

- none
- fade
- spin
- spin-inverse
- zoom

### API

- Enable the button

>```javascript
>$button.enable(status=boolean, disableEffect=boolean);
>```

- Resize the button

>```javascript
>$button.resize(width, height);
>```

- Show button

>```javascript
>$button.show(disableEffect=boolean);
>```

- Hide button

>```javascript
>$button.hide(disableEffect=boolean);
>```

- Toggle button

>```javascript
>$button.toggle(disableEffect=boolean);
>```

- Change theme

>```javascript
>$button.changeTheme(theme);
>```

- Change effect

>```javascript
>$button.changeEffect(effect);
>```

## TO-DO

- Create a nice website for the repo
- More themes
- More effects

## License

This project is licensed under MIT [https://opensource.org/licenses/MIT]

## Author

[Pablo Pizarro R.](https://ppizarror.com) | 2018 - 2019
