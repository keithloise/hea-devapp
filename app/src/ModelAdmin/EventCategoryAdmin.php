<?php

namespace {

    use SilverStripe\Admin\ModelAdmin;
    use SilverStripe\Forms\GridField\GridFieldFilterHeader;
    use SilverStripe\ORM\DataObject;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class EventCategoryAdmin extends ModelAdmin
    {
        private static $menu_icon_class = 'font-icon-tree';
        private static $url_segment = 'categories';
        private static $menu_title  = 'Categories';

        private static $managed_models  = [
            EventCategory::class,
            CategoryHistory::class
        ];

//        public function getEditForm($id = null, $fields = null)
//        {
//            $form = parent::getEditForm($id, $fields);
//            // $gridFieldName is generated from the ModelClass, eg if the Class 'Product'
//            // is managed by this ModelAdmin, the GridField for it will also be named 'Product'
//            if (class_exists('GridFieldOrderableRows')) {
//                $gridFieldName = $this->sanitiseClassName($this->modelClass);
//                if ($gridFieldName == 'EventCategory' && array_key_exists('Sort',
//                    EventCategory::get())
//                ) {
//                    $gridField = $form->Fields()->fieldByName($gridFieldName);
//                    $gridField->getConfig()->addComponent(new GridFieldOrderableRows());
//                }
//            }
//
//            return $form;
//        }

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
