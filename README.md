# POC Symfony UX

Discover the new features!  

## Infos  

> Post "Symfony UX Initiative" : [https://symfony.com/blog/symfony-ux-initiative](https://symfony.com/blog/new-in-symfony-the-ux-initiative-a-new-javascript-ecosystem-for-symfony)  
> GitHub Symfony UX : [https://github.com/symfony/ux](https://github.com/symfony/ux)  
> Hotwire : [https://www.hotwire.dev/](https://www.hotwire.dev/)  
> Stimulus Bridge : [https://github.com/symfony/stimulus-bridge](https://github.com/symfony/stimulus-bridge)

#### Docker

```
# Start
docker-compose up -d --build --remove-orphans

# Stop
docker-compose down --remove-orphans
```

#### Required

```
# Install Symfony 4.4+ and PHP 7.2+
composer create-project symfony/website-skeleton poc_symfony_ux && cd poc_symfony_ux

# Install Webpack Encore
composer require symfony/webpack-encore-bundle && yarn install --force
```

## Symfony UX Package  

### UX Chart
> GitHub : [https://github.com/symfony/ux-chartjs](https://github.com/symfony/ux-chartjs)  
> Source : [https://www.chartjs.org/](https://www.chartjs.org/)  

```
# Install UX Chart
composer require symfony/ux-chartjs && yarn install --force

# Build
yarn run build
```

### UX Cropper
> GitHub : [https://github.com/symfony/ux-cropperjs](https://github.com/symfony/ux-cropperjs)  
> Source : [https://fengyuanchen.github.io/cropperjs/](https://fengyuanchen.github.io/cropperjs/)

```
# Install UX Cropper
composer require symfony/ux-cropperjs && yarn install --force

# Build
yarn run build
```

### UX Dropzone
> GitHub : [https://github.com/symfony/ux-dropzone](https://github.com/symfony/ux-dropzone)  
> Source : [https://www.dropzonejs.com/](https://www.dropzonejs.com/)  

```
# Install UX Dropzone
composer require symfony/ux-dropzone && yarn install --force

# Build
yarn run build
```

### UX LazyImage
> GitHub : [https://github.com/symfony/ux-lazy-image](https://github.com/symfony/ux-lazy-image)  
> Source : [https://blurha.sh/](https://blurha.sh/)

```
# Install UX LazyImage
composer require symfony/ux-lazy-image && yarn install --force

# Build
yarn run build
```

### UX Swup
> GitHub : [https://github.com/symfony/ux-swup](https://github.com/symfony/ux-swup)  
> Source : [https://swup.js.org/](https://swup.js.org/)

```
# Install UX Swup
composer require symfony/ux-swup && yarn install --force

# Build
yarn run build
```
