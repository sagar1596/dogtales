CKEditor Read More

INTRODUCTION
============

This module adds a new element to CKEditor which allows users to hide selected
content and toggle it with "Read more" element click.

Installation
============
1.  Enable the module
2.  Drag and drop the Read More button to the CKEditor toolbar (admin/config/content/formats).
3.  If you have enabled "Limit allowed HTML tags" filter in Text formats and editors settings, check if you have <div data-readmore-less-text data-readmore-more-text data-readmore-type class="ckeditor-readmore"> present in the "Allowed HTML tags" section. Add it if it was not automacitally added.

Usage
=====

Select the text you want to hide and press the "Read more" button in CKEditor toolbar.

CONFIGURATION
=============

In editor setting you can choose between "Button" and "Text" type of toggling element under text.
You can also modify "Read more" and "Show less" translatable messages.
