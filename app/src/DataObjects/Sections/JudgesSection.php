<?php

namespace {

    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;

    class JudgesSection extends Section
    {
        private static $singular_name = "Judges Section";

        private static $db = [

        ];

        public function getVisibleJudgesThisYear()
        {
            $yearToday  = date('Y');
            $year = EventYear::get()->filter([
                'Archived' => false,
                'Name'     => $yearToday])->first();

            $categories = EventCategory::get()->filter([
                'Archived'    => false,
                'EventYearID' => $year->ID]);

            return $categories;
        }

//        public function getVisibleJudgesThisYear()
//        {
//            $yearToday  = date('Y');
//            $year = EventYear::get()->filter([
//                'Archived' => false,
//                'Name'     => $yearToday])->first();
//
//            $categories = EventCategory::get()->filter([
//                'Archived'    => false,
//                'EventYearID' => $year->ID]);
//
//            $output = new ArrayList();
//            foreach ($categories as $category) {
//                $judgesTest = $category->EventJudge();
//                $judges = EventJudge::get()->filter([
//                    'Archived'        => false,
//                    'EventCategoryID' => $category->ID
//                ]);
//
//                $judgesArray = new ArrayList();
//                foreach ($judges as $judge) {
//                    $judgesArray[] = new ArrayData(array(
//                        'Name' => $judge->Name,
//                        'Position' => $judge->Position,
//                        'Blurb'=> $judge->Blurb,
//                        'Image'=> $judge->Image
//                    ));
//                }
//                $childOutput = [
//                    'Name'   => $category->Name,
//                    'Judges' => $judgesArray
//                ];
//
//                $output[] = new ArrayData(array('Categories' => $childOutput));
//            }
//            return $output;
//        }
    }
}
