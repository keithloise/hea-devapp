<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;

    class GallerySection extends Section
    {
        private static $singular_name = "Gallery Section";

        private static $db = [
            'Content' => 'HTMLText'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }

        public function getVisibleGallery()
        {
            $eventYears = EventYear::get()->filter(['Archived' => false, 'ShowInGalleryPage' => true])->sort('ID', 'DESC');
            $output = new ArrayList();
            foreach ($eventYears as $year) {
                $galleries = EventGallery::get()->filter(['Archived' => false, 'EventYearID' => $year->ID]);
                $galleryArray = new ArrayList();
                foreach ($galleries as $gallery) {
                    $galleryArray[] = new ArrayData(array(
                        'Image' => $gallery->Image,
                    ));
                }
                $output[] = new ArrayData(array(
                    'Year'        => $year->Name,
                    'YearContent' => $year->GalleryPageExtraContent,
                    'Galleries'   => $galleryArray,
                ));
            }
            return $output;
        }
    }
}
