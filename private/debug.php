<?php
/**
 *wyswietla sformatowaną wiadomosc debug, jeśli zdefiniowano wyswietlanie.
 *@param string $wiadomosc do wyswietlenia.
 *@param bool $showBacktrace czy wyswietlac backtrace.
 */
function showDebugMessage($message, $showBacktrace=true, $saveBackTrace=false)
{
    if(DEBUG)
    {
        ?>
        <div class="debug" style="border:2px solid red;">
            <h3>
                <?php echo $message;?>
            </h3>
            <?php if($showBacktrace)
            {?>
            <pre><?php debug_print_backtrace();?></pre>
            <?php }
            ?>
        </div>
        <?php
    }
    if($saveBackTrace)
    error_log((date('Y-m-d H:i:s')."\t".$message."\t".print_r(debug_backtrace(), true)."\r\n"),3,'private/debug.log');
    else
    error_log((date('Y-m-d H:i:s')."\t".$message."\r\n"),3,'private/debug.log');
}