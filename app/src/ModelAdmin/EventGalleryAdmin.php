<?php

namespace {

    use SilverStripe\Admin\ModelAdmin;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class EventGalleryAdmin extends ModelAdmin
    {
        private static $menu_icon_class = 'font-icon-picture';
        private static $url_segment = 'galleries';
        private static $menu_title  = 'Gallery';

        private static $managed_models  = [
            EventGallery::class,
        ];

        public function getEditForm($id = null, $fields = null)
        {
            $form = parent::getEditForm($id, $fields);

            // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
            // is managed by this ModelAdmin, the GridField for it will also be named 'Product'
            $gridFieldName = $this->sanitiseClassName($this->modelClass);
            $gridField = $form->Fields()->fieldByName($gridFieldName);

            //Sortable Rows.
            $gridField->getConfig()->addComponent(new GridFieldOrderableRows());

            return $form;
        }
    }
}
