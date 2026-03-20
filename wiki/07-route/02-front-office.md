php bin/console debug:router
--------------------------------- ---------- ------------ ------ -----------------------------------------------------
Name                              Method     Scheme       Host   Path
--------------------------------- ---------- ------------ ------ -----------------------------------------------------
app.dashboard.index                       GET              http|https   /{_locale}/index.php
app.dashboard.noLocale                    GET              http|https   /
app.garage.create                         GET|POST         http|https   /{_locale}/garage/create.php
app.garage.delete                         POST             http|https   /{_locale}/garage/delete.php/{id}
app.garage.index                          GET              http|https   /{_locale}/garage/index.php
app.garage.read                           GET              http|https   /{_locale}/garage/read/{slug}-{id}.php
app.garage.update                         GET|POST         http|https   /{_locale}/garage/update/{slug}-{id}.php
app.page.filter.block                     GET              http|https   /{_locale}/pages/filter/block/class-{letter}.php
app.page.filter.gold                      GET              http|https   /{_locale}/pages/filter/gold/class-{letter}.php
app.page.filter.unblock                   GET              http|https   /{_locale}/pages/filter/unblock/class-{letter}.php
app.page.filter.evo                       GET              http|https   /{_locale}/pages/filter/evo/class-{letter}.php
app.page.filter.event                     GET              http|https   /{_locale}/pages/filter/event-class-{letter}.php
app.page.filter.to.upgrade                GET              http|https   /{_locale}/pages/filter/to-upgrade/class-{letter}.php
app.page.filter.to.unblock                GET              http|https   /{_locale}/pages/filter/to-unblock/class-{letter}.php
app.page.filter.to.install.upgrade        GET              http|https   /{_locale}/pages/filter/to-install-upgrade/class-{letter}.php
app.page.filter.to.install.import         GET              http|https   /{_locale}/pages/filter/to-install-import/class-{letter}.php
app.page.filter.to.gold                   GET              http|https   /{_locale}/pages/filter/to-gold/class-{letter}.php
app.page.filter.full.blueprint            GET              http|https   /{_locale}/pages/filter/full-blueprint/class-{letter}.php
app.page.filter.full.evo                  GET              http|https   /{_locale}/pages/filter/full-evo/class-{letter}.php
app.mission.index                         GET              http|https   /{_locale}/mission/index.php
app.page.order.class                      GET              http|https   /{_locale}/pages/order/class/class-{letter}.php
app.page.order.stat                       GET              http|https   /{_locale}/pages/order/stat/class-{letter}.php
app.race.index                            GET              http|https   /{_locale}/race/index.php
app.page.search.garage                    GET|POST         http|https   /{_locale}/pages/search/garage.php
app.page.search.race                      GET|POST         http|https   /{_locale}/pages/search/race.php
----------------------------------------- ---------------- ------------ ---------------------------------------------------------------
