Magento Lite experiment by Ivan Weiler
======================================

*Do not use this in production environments, this is just an experiment!!*

Magento Lite is extension that compensates module dependency and makes Magento truly modular.
By default it fully disables over 35 default Magento modules, there are over 120 DB tables less and 
over 2000 files can be safely deleted from Magento.

Any single disabled module can be enabled and restored again.

It removes "system" flag from most not needed attributes and creates optional Lite attribute set.
It hides non-active modules in "Disable Modules Output".
It optionally hides Recurrent Billing, Billing Agreements, Related, Upsell, Crosssell products from administration (WIP).

Copyright (c) 2011 Ivan Weiler


Goal
----
To have only basic e-commerce functionalities like catalog, cart, checkout, etc. in Magento.
To have fully upgradable platform ideal for custom projects and learning purposes.


Compatibility
-------------
Magento CE >= 1.6.0.0. Tested on 1.6.0.0 and 1.6.1.0.


Instalation
-----------
Download Magento and unpack, copy/paste Weiler_Lite module in it, install Magento.

It's tested only along fresh/clean installations. In theory it should work on already set store, but then 
database has unneeded tables and attributes since this module doesn't remove them and probably never will.
It's not tested with sample data, but it probably works.

To enable any disabled module edit app/etc/modules/Weiler_Lite.xml and set its <active> to true.


Notes
-----
Mage_CatalogRule and Mage_Rule can also be safely disabled/removed, but there is no way to do that without 
touching Mage_All.xml since there is no way to rewrite <depends> definitions. There is Mage_All.xml.lite 
file if someone wants to experiment.

Mage_Dataflow can also be disabled this way, but that module shouldn't be deleted since Eav is extending few 
classes from there.

I also wanted to disable Mage_Reports and Mage_Log but 30% of Magento is broken then.

Rss, Weee, Wishlist and GiftMessage helpers are rewritten to avoid changing tons of theme phtml files.
It was just easier this way, method is highly questionable. Otherwise we need lite frontend theme.
Current frontend lite theme is just experimental, it can be removed.

Some block are deliberately rewritten instead of using hooks, it's easier to maintain updates that way.

It would be great to create diff file for every deactivated module that could be used to fully delete every 
associated file(module, its Adminhtml files, it's frontend/adminhtml theme files).


Changelog
---------
06.11.2011. Magento Lite 1.6.1.0, few bugfixes, public release
22.10.2011. Magento Lite 1.6.0.0 beta1

