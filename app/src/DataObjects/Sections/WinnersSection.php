<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;

    class WinnersSection extends Section
    {
        private static $singular_name = "Winners Section";

        private static $db = [
            'Content' => 'HTMLText',
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }

        public function getVisibleEventWinners()
        {
            $eventYears = EventYear::get()->filter(['Archived' => false, 'ShowInWinnersPage' => true])->sort('ID', 'DESC');
            $output = new ArrayList();
            foreach ($eventYears as $year) {
                $categories = CategoryHistory::get()->filter(['Archived' => false, 'EventYear' => $year->Name]);
                $categoryArray = new ArrayList();
                foreach ($categories as $category) {
                    $finalists = EventFinalist::get()->filter(['EventYearID' => $year->ID, 'EventCategoryID' => $category->ID, 'Results' => '1']);
                    if (count($finalists)) {
                        $finalistsArray = new ArrayList();
                        foreach($finalists as $finalist) {
                            $finalistsArray[] = new ArrayData(array(
                                'Name'    => $finalist->Name,
                                'Image'   => $finalist->WinnerImage,
                                'Content' => $finalist->WinnerContent,
                            ));
                        }
                        $categoryArray[] = new ArrayData(array(
                            'Name' => $category->Name,
                            'Content' => $category->FinalistsContent,
                            'Winners' => $finalistsArray
                        ));
                    }
                }
                $childOutput = [
                    'Year'        => $year->Name,
                    'YearContent' => $year->WinnersPageExtraContent,
                    'Categories'  => $categoryArray
                ];
                $output[] = new ArrayData(array('Winners' => $childOutput));
            }
            return $output;
        }
    }
}
