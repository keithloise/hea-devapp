<?php

namespace {

    use SilverStripe\Admin\ModelAdmin;

    class EventJudgesAdmin extends ModelAdmin
    {
        private static $menu_icon_class = 'font-icon-torsos-all';
        private static $url_segment = 'judges';
        private static $menu_title  = 'Judges';

        private static $managed_models  = [
            EventJudge::class
        ];
    }
}
