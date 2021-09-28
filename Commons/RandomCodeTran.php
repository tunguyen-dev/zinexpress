<?php
// namespace Commons;
class Commons_RandomCodeTran{
	static function tranid() {
        $milliseconds = round(microtime(true) * 1000);
        $tran_id = "CK".$milliseconds;
        return $tran_id;
    }
}