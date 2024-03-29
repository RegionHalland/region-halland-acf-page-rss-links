# Hämta RSS-flöde

## Hur man använder Region Hallands plugin "region-halland-acf-page-rss-links"

Nedan följer instruktioner hur du kan använda pluginet "region-halland-acf-page-rss-links".


## Användningsområde

Denna plugin hämtar valfritt rss-flöde


## Licensmodell

Denna plugin använder licensmodell GPL-3.0. Du kan läsa mer om denna licensmodell via den medföljande filen:
```sh
LICENSE (https://github.com/RegionHalland/region-halland-acf-page-rss-links/blob/master/LICENSE)
```


## Installation och aktivering

```sh
A) Hämta pluginen via Git eller läs in det med Composer
B) Installera Region Hallands plugin i Wordpress plugin folder
C) Aktivera pluginet inifrån Wordpress admin
```


## Hämta hem pluginet via Git

```sh
git clone https://github.com/RegionHalland/region-halland-acf-page-rss-links.git
```


## Läs in pluginen via composer

Dessa två delar behöver du lägga in i din composer-fil

Repositories = var pluginen är lagrad, i detta fall på github

```sh
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/RegionHalland/region-halland-acf-page-rss-links.git"
  },
],
```
Require = anger vilken version av pluginen du vill använda, i detta fall version 1.0.0

OBS! Justera så att du hämtar aktuell version.

```sh
"require": {
  "regionhalland/region-halland-acf-page-rss-links": "1.0.0"
},
```


## Visa länken i en i-frame via "Blade"

```sh
@php($myData = get_region_halland_acf_page_rss_link_items())
@if($myData['has_content'] == 1)
  <h3>{{$myData['title']}}</h3><br>
  @foreach ($myData['rss'] as $data)
    <a href="{{ $data['link'] }}"><strong>{!! $data['title'] !!}</strong></a><br>
    <p>{{ $data['description'] }}</p>
    <p><i>{{ $data['date'] }}</i></p><br>
  @endforeach
@endif
```


## Versionhistorik

### 1.4.0
- Uppdaterat information om licensmodell
- Bifogat fil med licensmodell

### 1.3.0
- Ändrat namn på ett ACF-fält

### 1.2.0
- Lagt till en kontroll om url existerar

### 1.1.0
- Lagt till en kontroll om det finns en angiven url

### 1.0.0
- Första version