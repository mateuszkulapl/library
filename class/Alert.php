<?php
class Alert
{
    private $message;
    private $type;
    private $showOnlyInDebugMode;
    private $backtrace;

    /**
     * Konstruktor
     *
     * @param string $wiadomosć wyświetlana
     * @param string $rodzaj wiadomości (info/warning/success/error)
     * @param boolean $showOnlyInDebugMode wiadomosc zostanie wyświetlona tylko w trybie debugowania
     * @param boolean $backtrace
     */
    public function __construct($message, $type = "info", $showOnlyInDebugMode = false, $backtrace = null)
    {
        $allowedTypes = ["info", "warning", "success", "error"];
        if (!in_array($type, $allowedTypes))
            $type = "info";
        $this->message = $message;
        $this->type = $type;
        $this->showOnlyInDebugMode = $showOnlyInDebugMode;
        $this->backtrace = $backtrace;
    }

    public function render($index = 0)
    {
        global $debugMode;
        if ((!($this->showOnlyInDebugMode)) || ($this->showOnlyInDebugMode && $debugMode)) : ?>
            <div id="alert-<?php echo $index; ?>" class="alert <?php echo $this->type; ?>">
                <p class="message"><?php echo $this->message; ?></p>
                <?php if ($debugMode && $this->backtrace != null) : ?>
                    <div class="backtrace"><?php echo $this->backtrace; ?></div>
                <?php endif; ?>
                <span class="close">x</span>
            </div>
<?php
        endif;
    }
}
