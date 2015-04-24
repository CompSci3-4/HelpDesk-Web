<?php
/**
 * The status of a Ticket (e.g. Completed).
 *
 * This class consists of a series of constants (integers),
 * each representing a different status a ticket can have.
 */ 
abstract class Status {
    const InProgress = 5;
    const Completed = 6;

    /**
     * Converts a Status to a string, for output purposes.
     *
     * @param int $id the Status to convert.
     * @return string the name of the status.
     */
    public static function toString($id) {
        $strings = [Status::InProgress => "In Progress",
                    Status::Completed => "Completed"];
        return $strings[$id];
    }

    /**
     * @return array a list of all possible statuses.
     */
    public static function allStatuses() {
        return [Status::InProgress, Status::Completed];
    }
}
?>
