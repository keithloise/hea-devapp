<?php

namespace {

    use SilverStripe\Admin\ModelAdmin;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class EventFinalistAdmin extends ModelAdmin
    {
        private static $menu_icon_class = 'font-icon-circle-star';
        private static $url_segment = 'finalists';
        private static $menu_title  = 'Finalists';

        private static $managed_models  = [
            EventFinalist::class,
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
