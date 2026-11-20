# Foundation

CubeCart v6's original responsive skin, built on the [Foundation 5](https://get.foundation/sites/docs-v5/) framework (5.5.2). It is deliberately plain, which made it the usual starting point for custom skins.

Foundation shipped inside the CubeCart package up to 6.8.x. From CubeCart 6.9.0 the package contains only [Atrium](https://github.com/cubecart/v6/tree/v6.x-master/skins/atrium), and Foundation is maintained here.

Foundation has its own version numbers from here on, starting at 1.0.0, which is the Foundation that shipped with CubeCart 6.8.6. Copies from earlier CubeCart packages say `n/a` in `config.xml`. Which CubeCart versions it works with is set by `minVersion` and `maxVersion` in `config.xml`, not by its version number.

## Installing

Copy this folder to `skins/foundation` in your store, then choose Foundation under Store Settings, Layout.

## Upgrading CubeCart

A store that already uses Foundation keeps it when it upgrades to CubeCart 6.9.0 or later: the upgrade does not delete files under `skins/`. Later fixes to Foundation come from this repository, not from the CubeCart package.

## Custom skins based on Foundation

Give your copy its own folder name, `uid`, `name` and `version` in `config.xml`, so it is never mistaken for, or overwritten by, a newer Foundation.

## History

The commits from before the move were carried over from [cubecart/v6](https://github.com/cubecart/v6) with their dates and authors, so issue numbers such as #4264 in the log refer to issues in that repository.
