document.addEventListener("DOMContentLoaded", () => {
    localStorage.setItem('currentFontSize0', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-0')));
    localStorage.setItem('currentFontSize6', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-6')));
    localStorage.setItem('currentFontSize10', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-10')));
    localStorage.setItem('currentFontSize11', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-11')));
    localStorage.setItem('currentFontSize12', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-12')));
    localStorage.setItem('currentFontSize126', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-12-6')));
    localStorage.setItem('currentFontSize13', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-13')));
    localStorage.setItem('currentFontSize135', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-13-5')));
    localStorage.setItem('currentFontSize14', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-14')));
    localStorage.setItem('currentFontSize144', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-14-4')));
    localStorage.setItem('currentFontSize145', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-14-5')));
    localStorage.setItem('currentFontSize15', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-15')));
    localStorage.setItem('currentFontSize16', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-16')));
    localStorage.setItem('currentFontSize17', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-17')));
    localStorage.setItem('currentFontSize18', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-18')));
    localStorage.setItem('currentFontSize20', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-20')));
    localStorage.setItem('currentFontSize21', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-21')));
    localStorage.setItem('currentFontSize216', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-21-6')));
    localStorage.setItem('currentFontSize22', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-22')));
    localStorage.setItem('currentFontSize24', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-24')));
    localStorage.setItem('currentFontSize25', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-25')));
    localStorage.setItem('currentFontSize252', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-25-2')));
    localStorage.setItem('currentFontSize288', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-28-8')));
    localStorage.setItem('currentFontSize29', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-29')));
    localStorage.setItem('currentFontSize32', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-32')));
    localStorage.setItem('currentFontSize36', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-36')));
    localStorage.setItem('currentFontSize40', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-40')));
    localStorage.setItem('currentFontSize48', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-48')));
    localStorage.setItem('currentFontSize56', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-56')));
    localStorage.setItem('currentFontSize64', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-64')));
    localStorage.setItem('currentFontSize72', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-72')));
    localStorage.setItem('currentFontSize80', parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--afu-font-size-80')));
});

function changeTheme(theme) {
    if (theme === 'dark') {
        document.documentElement.style.setProperty('--background-color', 'black');
        document.documentElement.style.setProperty('--text-color', 'white');
    } else {
        document.documentElement.style.setProperty('--background-color', 'white');
        document.documentElement.style.setProperty('--text-color', 'black');
    }
    localStorage.setItem('theme', theme);
    applyPalette(localStorage.getItem('palette') || 'red');
}

function changePalette(color) {
    localStorage.setItem('palette', color);
    applyPalette(color);
}

function applyPalette(color) {
    let colorVariable;
    if (document.documentElement.style.getPropertyValue('--background-color') === 'black') {
        colorVariable = `--afu-dark-theme-primary-${color}`;
        colorrgbVariable = `--afu-dark-theme-rgb-part-primary-${color}`;
        colordarkenVariable = `--afu-dark-theme-darken-primary-${color}`;
    } else {
        colorVariable = `--afu-light-theme-primary-${color}`;
        colorrgbVariable = `--afu-light-theme-rgb-part-primary-${color}`;
        colordarkenVariable = `--afu-light-theme-darken-primary-${color}`;
    }
    document.documentElement.style.setProperty('--afu-light-theme-primary', `var(${colorVariable})`);
    document.documentElement.style.setProperty('--afu-light-theme-rgb-part-primary',
        `var(${colorrgbVariable})`);
    document.documentElement.style.setProperty('--afu-light-theme-darken-primary',
        `var(${colordarkenVariable})`);
}

function changeFontSize(size) {
    let currentFontSize0 = localStorage.getItem('currentFontSize0');
    let currentFontSize6 = localStorage.getItem('currentFontSize6');
    let currentFontSize10 = localStorage.getItem('currentFontSize10');
    let currentFontSize11 = localStorage.getItem('currentFontSize11');
    let currentFontSize12 = localStorage.getItem('currentFontSize12');
    let currentFontSize126 = localStorage.getItem('currentFontSize126');
    let currentFontSize13 = localStorage.getItem('currentFontSize13');
    let currentFontSize135 = localStorage.getItem('currentFontSize135');
    let currentFontSize14 = localStorage.getItem('currentFontSize14');
    let currentFontSize144 = localStorage.getItem('currentFontSize144');
    let currentFontSize145 = localStorage.getItem('currentFontSize145');
    let currentFontSize15 = localStorage.getItem('currentFontSize15');
    let currentFontSize16 = localStorage.getItem('currentFontSize16');
    let currentFontSize17 = localStorage.getItem('currentFontSize17');
    let currentFontSize18 = localStorage.getItem('currentFontSize18');
    let currentFontSize20 = localStorage.getItem('currentFontSize20');
    let currentFontSize21 = localStorage.getItem('currentFontSize21');
    let currentFontSize216 = localStorage.getItem('currentFontSize216');
    let currentFontSize22 = localStorage.getItem('currentFontSize22');
    let currentFontSize24 = localStorage.getItem('currentFontSize24');
    let currentFontSize25 = localStorage.getItem('currentFontSize25');
    let currentFontSize252 = localStorage.getItem('currentFontSize252');
    let currentFontSize288 = localStorage.getItem('currentFontSize288');
    let currentFontSize29 = localStorage.getItem('currentFontSize29');
    let currentFontSize32 = localStorage.getItem('currentFontSize32');
    let currentFontSize36 = localStorage.getItem('currentFontSize36');
    let currentFontSize40 = localStorage.getItem('currentFontSize40');
    let currentFontSize48 = localStorage.getItem('currentFontSize48');
    let currentFontSize56 = localStorage.getItem('currentFontSize56');
    let currentFontSize64 = localStorage.getItem('currentFontSize64');
    let currentFontSize72 = localStorage.getItem('currentFontSize72');
    let currentFontSize80 = localStorage.getItem('currentFontSize80');

    let newSizeSmaller0 = currentFontSize0 - 3;
    let newSizeSmaller6 = currentFontSize6 - 3;
    let newSizeSmaller10 = currentFontSize10 - 3;
    let newSizeSmaller11 = currentFontSize11 - 3;
    let newSizeSmaller12 = currentFontSize12 - 3;
    let newSizeSmaller126 = currentFontSize126 - 3;
    let newSizeSmaller13 = currentFontSize13 - 3;
    let newSizeSmaller135 = currentFontSize135 - 3;
    let newSizeSmaller14 = currentFontSize14 - 3;
    let newSizeSmaller144 = currentFontSize144 - 3;
    let newSizeSmaller145 = currentFontSize145 - 3;
    let newSizeSmaller15 = currentFontSize15 - 3;
    let newSizeSmaller16 = currentFontSize16 - 3;
    let newSizeSmaller17 = currentFontSize17 - 3;
    let newSizeSmaller18 = currentFontSize18 - 3;
    let newSizeSmaller20 = currentFontSize20 - 3;
    let newSizeSmaller21 = currentFontSize21 - 3;
    let newSizeSmaller216 = currentFontSize216 - 3;
    let newSizeSmaller22 = currentFontSize22 - 3;
    let newSizeSmaller24 = currentFontSize24 - 3;
    let newSizeSmaller25 = currentFontSize25 - 3;
    let newSizeSmaller252 = currentFontSize252 - 3;
    let newSizeSmaller288 = currentFontSize288 - 3;
    let newSizeSmaller29 = currentFontSize29 - 3;
    let newSizeSmaller32 = currentFontSize32 - 3;
    let newSizeSmaller36 = currentFontSize36 - 3;
    let newSizeSmaller40 = currentFontSize40 - 3;
    let newSizeSmaller48 = currentFontSize48 - 3;
    let newSizeSmaller56 = currentFontSize56 - 3;
    let newSizeSmaller64 = currentFontSize64 - 3;
    let newSizeSmaller72 = currentFontSize72 - 3;
    let newSizeSmaller80 = currentFontSize80 - 3;

    let newSizeBigger0 = currentFontSize0 - (-3);
    let newSizeBigger6 = currentFontSize6 - (-3);
    let newSizeBigger10 = currentFontSize10 - (-3);
    let newSizeBigger11 = currentFontSize11 - (-3);
    let newSizeBigger12 = currentFontSize12 - (-3);
    let newSizeBigger126 = currentFontSize126 - (-3);
    let newSizeBigger13 = currentFontSize13 - (-3);
    let newSizeBigger135 = currentFontSize135 - (-3);
    let newSizeBigger14 = currentFontSize14 - (-3);
    let newSizeBigger144 = currentFontSize144 - (-3);
    let newSizeBigger145 = currentFontSize145 - (-3);
    let newSizeBigger15 = currentFontSize15 - (-3);
    let newSizeBigger16 = currentFontSize16 - (-3);
    let newSizeBigger17 = currentFontSize17 - (-3);
    let newSizeBigger18 = currentFontSize18 - (-3);
    let newSizeBigger20 = currentFontSize20 - (-3);
    let newSizeBigger21 = currentFontSize21 - (-3);
    let newSizeBigger216 = currentFontSize216 - (-3);
    let newSizeBigger22 = currentFontSize22 - (-3);
    let newSizeBigger24 = currentFontSize24 - (-3);
    let newSizeBigger25 = currentFontSize25 - (-3);
    let newSizeBigger252 = currentFontSize252 - (-3);
    let newSizeBigger288 = currentFontSize288 - (-3);
    let newSizeBigger29 = currentFontSize29 - (-3);
    let newSizeBigger32 = currentFontSize32 - (-3);
    let newSizeBigger36 = currentFontSize36 - (-3);
    let newSizeBigger40 = currentFontSize40 - (-3);
    let newSizeBigger48 = currentFontSize48 - (-3);
    let newSizeBigger56 = currentFontSize56 - (-3);
    let newSizeBigger64 = currentFontSize64 - (-3);
    let newSizeBigger72 = currentFontSize72 - (-3);
    let newSizeBigger80 = currentFontSize80 - (-3);

    if (size === 'small') {
        document.documentElement.style.setProperty('--afu-font-size-0', newSizeSmaller0 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-6', newSizeSmaller6 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-10', newSizeSmaller10 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-11', newSizeSmaller11 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-12', newSizeSmaller12 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-12-6', newSizeSmaller126 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-13', newSizeSmaller13 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-13-5', newSizeSmaller135 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14', newSizeSmaller14 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14-4', newSizeSmaller144 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14-5', newSizeSmaller145 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-15', newSizeSmaller15 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-16', newSizeSmaller16 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-17', newSizeSmaller17 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-18', newSizeSmaller18 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-20', newSizeSmaller20 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-21', newSizeSmaller21 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-21-6', newSizeSmaller216 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-22', newSizeSmaller22 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-24', newSizeSmaller24 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-25', newSizeSmaller25 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-25-2', newSizeSmaller252 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-28-8', newSizeSmaller288 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-29', newSizeSmaller29 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-32', newSizeSmaller32 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-36', newSizeSmaller36 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-40', newSizeSmaller40 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-48', newSizeSmaller48 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-56', newSizeSmaller56 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-64', newSizeSmaller64 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-72', newSizeSmaller72 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-80', newSizeSmaller80 + 'px');
        localStorage.setItem('fontSize', 'small');
    } else if (size === 'medium') {
        document.documentElement.style.setProperty('--afu-font-size-0', currentFontSize0 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-6', currentFontSize6 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-10', currentFontSize10 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-11', currentFontSize11 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-12', currentFontSize12 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-12-6', currentFontSize126 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-13', currentFontSize13 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-13-5', currentFontSize135 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14', currentFontSize14 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14-4', currentFontSize144 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14-5', currentFontSize145 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-15', currentFontSize15 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-16', currentFontSize16 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-17', currentFontSize17 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-18', currentFontSize18 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-20', currentFontSize20 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-21', currentFontSize21 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-21-6', currentFontSize216 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-22', currentFontSize22 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-24', currentFontSize24 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-25', currentFontSize25 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-25-2', currentFontSize252 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-28-8', currentFontSize288 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-29', currentFontSize29 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-32', currentFontSize32 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-36', currentFontSize36 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-40', currentFontSize40 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-48', currentFontSize48 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-56', currentFontSize56 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-64', currentFontSize64 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-72', currentFontSize72 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-80', currentFontSize80 + 'px');
        localStorage.setItem('fontSize', 'medium');
    } else if (size === 'big') {
        document.documentElement.style.setProperty('--afu-font-size-0', newSizeBigger0 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-6', newSizeBigger6 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-10', newSizeBigger10 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-11', newSizeBigger11 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-12', newSizeBigger12 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-12-6', newSizeBigger126 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-13', newSizeBigger13 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-13-5', newSizeBigger135 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14', newSizeBigger14 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14-4', newSizeBigger144 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-14-5', newSizeBigger145 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-15', newSizeBigger15 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-16', newSizeBigger16 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-17', newSizeBigger17 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-18', newSizeBigger18 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-20', newSizeBigger20 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-21', newSizeBigger21 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-21-6', newSizeBigger216 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-22', newSizeBigger22 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-24', newSizeBigger24 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-25', newSizeBigger25 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-25-2', newSizeBigger252 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-28-8', newSizeBigger288 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-29', newSizeBigger29 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-32', newSizeBigger32 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-36', newSizeBigger36 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-40', newSizeBigger40 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-48', newSizeBigger48 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-56', newSizeBigger56 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-64', newSizeBigger64 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-72', newSizeBigger72 + 'px');
        document.documentElement.style.setProperty('--afu-font-size-80', newSizeBigger80 + 'px');
        localStorage.setItem('fontSize', 'big');
    }

}

// On page load
document.addEventListener('DOMContentLoaded', (event) => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    const savedPalette = localStorage.getItem('palette') || 'first';
    const savedFontSize = localStorage.getItem('fontSize') || 'medium';
    console.log(savedFontSize);
    if (savedPalette == 'first') {
        const optionPalette = document.getElementById('layout-palette-first');
        optionPalette.checked = true;
    } else if (savedPalette == 'second') {
        const optionPalette = document.getElementById('layout-palette-second');
        optionPalette.checked = true;
    } else if (savedPalette == 'third') {
        const optionPalette = document.getElementById('layout-palette-third');
        optionPalette.checked = true;
    } else if (savedPalette == 'fourth') {
        const optionPalette = document.getElementById('layout-palette-fourth');
        optionPalette.checked = true;
    }
    if (savedFontSize == 'small') {
        const optionPalette = document.getElementById('font-size-small');
        optionPalette.checked = true;
    } else if (savedFontSize == 'medium') {
        const optionPalette = document.getElementById('font-size-medium');
        optionPalette.checked = true;
    } else if (savedFontSize == 'big') {
        const optionPalette = document.getElementById('font-size-big');
        optionPalette.checked = true;
    }
    changeTheme(savedTheme);
    applyPalette(savedPalette);
    changeFontSize(savedFontSize);
});