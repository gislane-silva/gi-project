<?php

namespace App\Services\Transactions;

class TransactionService
{
    /**
     * @return bool
     */
    public function transactionIsAuthorized()
    {
        $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
        return $this->runApi($url);
    }

    /**
     * @return bool
     */
    public function notify()
    {
        $url = 'http://o4d9z.mocklab.io/notify';
        return $this->runApi($url);
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function runApi(string $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return true;
        }

        return false;
    }
}
