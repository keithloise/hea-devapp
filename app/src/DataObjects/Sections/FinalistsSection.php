<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\LabelField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;

    class FinalistsSection extends Section
    {
        private static $singular_name = "Finalists Section";

        private static $db = [
            'Content' => 'HTMLText',
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }

        public function getVisibleEventFinalists()
        {
            $eventYears = EventYear::get()->filter('Archived', false)->sort('ID', 'DESC');
            $output = new ArrayList();
            foreach ($eventYears as $year) {
                $categories = CategoryHistory::get()->filter(['Archived' => false, 'EventYear' => $year->Name]);
                $categoryArray = new ArrayList();
                foreach ($categories as $category) {
                    $finalists = EventFinalist::get()->filter(['Archived' => false, 'EventYearID' => $year->ID, 'EventCategoryID' => $category->ID]);
                    $finalistsArray = new ArrayList();
                    foreach($finalists as $finalist) {
                        $finalistsArray[] = new ArrayData(array(
                            'Name'    => $finalist->Name,
                            'Image'   => $finalist->Image,
                            'Content' => $finalist->Content,
                        ));
                    }
                    $categoryArray[] = new ArrayData(array(
                        'Name'=> $category->Name,
                        'Content' => $category->FinalistsContent,
                        'Finalists' => $finalistsArray
                    ));
                }
                $childOutput = [
                    'Year'     => $year->Name,
                    'Categories' => $categoryArray
                ];
                $output[] = new ArrayData(array('Finalists' => $childOutput));
            }
            return $output;
        }
    }
}
