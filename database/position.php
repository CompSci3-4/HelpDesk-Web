<?php
/**
 * The position of a User (e.g. user, consultant, manager).
 *
 * This class contains several constants (integers) that serve to represent 
 * the position of a User. These constants are ordered based on access level
 * (e.g. Admin > Manager), for easier use.
 */
abstract class Position {
    const User = 1;
    const Consultant = 2;
    const Manager = 3;
    const Admin = 4;

    /**
     * Converts a Position to a string, for output purposes.
     *
     * @param int $id the Position to convert.
     * @return string the name of the position.
     */
    public static function toString($id) {
        $strings = [Position::User => "User",
                    Position::Consultant => "Consultant",
                    Position::Manager => "Manager",
                    Position::Admin => "Admin"];
        return $strings[$id];
    }
}
?>
