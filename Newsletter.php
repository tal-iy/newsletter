<?php
require 'config.php';
class Newsletter
{
    private $method;
    private $action;
    private $validation = DEFAULT_VALIDATION;

    public function __construct($method, $action)
    {
        $this->method = $method;
        $this->action = $action;
    }

    /**
     * Changes whether form validation is used when displaying the sign-up form
     * @param bool $validation
     * @return void
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * Shows the sign-up form when the user navigates to the index.php page.
     * If the user has already submitted the form and there is an error to display,
     * the name and email fields are populated with sanitized values from their submission.
     * If the submission is successful, a success message is displayed instead of the form.
     * @return void
     */
    public function showForm()
    {
        // Show form for new connections and for failed submissions
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !self::submitForm())
        {
            // Escape user inputs before displaying
            $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
            $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';

            // Build the form elements
            echo '<form id="newsletter-form" method="'.$this->method.'" action="'.$this->action.'" '.($this->validation?'':'novalidate').'>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="'.$name.'" '.($this->validation?'required':'').'><br><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="'.$email.'" '.($this->validation?'required':'').'><br><br>
                <button type="submit">Sign Up</button>
            </form>';
        }
    }

    /**
     * Processes the form submission and adds a new record to the database.
     * The name and email fields are validated for proper length.
     * @return bool true if submission is successful, false otherwise.
     */
    public function submitForm(): bool
    {
        // Make sure inputs are not empty and don't exceed database string limits
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        if (empty($name) || strlen($name) > MAX_NAME_LENGTH || empty($email) || strlen($email) > MAX_EMAIL_LENGTH)
        {
            echo 'There was an error in your form, please try again.<br><br>';
            return false;
        }

        // Create a new database connection
        $db = new mysqli(DB_CONFIG['host'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['dbname']);
        if ($db->connect_error)
        {
            echo 'Could not connect to database.<br><br>';
            return false;
        }

        // Add submission to the database
        $stmt = $db->prepare('INSERT INTO submissions (name, email, date) VALUES (?, ?, now())');
        $stmt->bind_param('ss', $name, $email);

        try
        {
            $stmt->execute();
        }
        catch (mysqli_sql_exception $e)
        {
            echo 'Failed to add your email to the list, please try again using a different email.<br><br>';
            return false;
        }
        finally
        {
            $stmt->close();
            $db->close();
        }

        echo '<h3>Thank you for signing up for our newsletter!</h3>';
        return true;
    }

    /**
     * Shows the current list of people signed up for the newsletter,
     * ordered by submission date (descending).
     * @return void
     */
    public static function showList()
    {
        // Create a new database connection
        $db = new mysqli(DB_CONFIG['host'], DB_CONFIG['username'], DB_CONFIG['password'], DB_CONFIG['dbname']);
        if ($db->connect_error)
        {
            echo 'Could not connect to database.<br><br>';
            return false;
        }

        $result = $db->query('SELECT * FROM submissions ORDER BY date DESC');
        if ($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                echo '<tr><td>'.htmlspecialchars($row['name']).'</td><td>'.htmlspecialchars($row['email']).'</td><td>'.htmlspecialchars($row['date']).'</td></tr>';
            }
        }
        else
        {
            echo "<tr><td colspan='3'>No submissions yet.</td></tr>";
        }
    }
}