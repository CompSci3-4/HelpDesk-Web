<?php
abstract class Status {
    const InProgress = 5;
    const Completed = 6;

    public static function toString($id) {
        $strings = [Status::InProgress => "In Progress",
                    Status::Completed => "Completed"];
        return $strings[$id];
    }

    public static function allStatuses() {
        return [Status::InProgress, Status::Completed];
    }
}
?>
