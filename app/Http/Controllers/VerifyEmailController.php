<?php

namespace App\Http\Controllers;

use App\Exceptions\VerifyEmailException;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    protected $port = 25;
    protected $from = 'support@neotel.mk';
    protected $max_connection_timeout = 30;
    protected $stream_timeout = 5;
    protected $stream_timeout_wait = 0;
    protected $error_count = 0;
    protected $stream = false;
    protected $error; 


    // validacija na emailot dali e email ako postoi @
    public function validateEmail($email)
    {
        return (boolean) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * ги проверува сите SMTP сервери за дадената email адреса и враќа резултат дали таа постои и дали е валидна.
     * Влезни параметри: $email - адресата која треба да се провери.
     * Излезни параметри: враќа true ако адресата е валидна и постои, false во спротивно.
     */
    public function checkEmail($email)
    {
        $result = false;

        if (!$this->validateEmail($email)) {
            $this->setError("{$email} incorrect e-mail");
            throw new VerifyEmailException($this->getError());
        }

        $this->error_count = 0;
        $this->stream = false;

        $mxs = $this->getMXrecords($this->parseEmail($email));
        $timeout = ceil($this->max_connection_timeout / count($mxs)); // konvertira vo cel broj, 30 / 3 ako imam 3 mx records 

        foreach ($mxs as $host) {
            $this->stream = @stream_socket_client("tcp://" . $host . ":" . $this->port, $errno, $errstr, $timeout);
            if ($this->stream === false) {
                if ($errno == 0) {
                    $this->setError("Problem initializing the socket");
                    throw new VerifyEmailException($this->getError());
                }
            } else {
                stream_set_timeout($this->stream, $this->stream_timeout);
                stream_set_blocking($this->stream, 1);

                if ($this->streamCode($this->streamResponse()) == '220') {
                    $result = true;
                    break;
                } else {
                    fclose($this->stream);
                    $this->stream = false;
                }
            }
        }

        if ($this->stream === false) {
            $this->setError("All connection fails");
            throw new VerifyEmailException($this->getError());
        }

        $this->streamQuery("HELO " . $this->parseEmail($this->from));
        $this->streamResponse();
        $this->streamQuery("MAIL FROM: <{$this->from}>");
        $this->streamResponse();
        $this->streamQuery("RCPT TO: <{$email}>");
        $code = $this->streamCode($this->streamResponse());
        $this->streamResponse();
        $this->streamQuery("RSET");
        $this->streamResponse();
        $code2 = $this->streamCode($this->streamResponse());
        $this->streamQuery("QUIT");
        fclose($this->stream);

        $code = !empty($code2) ? $code2 : $code;

        switch ($code) {
            case '250':
            case '450':
            case '451':
            case '452':
                $result = true;
                break;
            case '550':
                $result = false;
                break;
            default:
                $result = false;
        }

        return $result;
    }

    /**
    * parseEmail -> Оваа метода го издвојува доменот од дадената email адреса.
    * Влезни параметри: $email - email адресата која треба да се раздели.
    * Излезни параметри: враќа само доменот на адресата.
    */
    /**
     * Домен на email адресата е делот од адресата што следува по @ знакот. За подобро објаснување, еве неколку примери:

    * Пример 1:
    *    Email адреса: example@example.com
    *    Домен: example.com

    * Пример 2:
    *    Email адреса: john.doe@example.net
    *    Домен: example.net

    * Пример 3:
    *    Email адреса: info@subdomain.example.org
    *    Домен: subdomain.example.org

    * Во секој од овие примери, доменот е сегментот од email адресата по @ знакот. 
     */

     /**
      * Во контекстот на методата parseEmail($email), sscanf() се користи за да се исклучи доменот од дадената email адреса.

    * Првиот аргумент е текстот кој сакаме да го скенираме ($email во овој случај).
    * Вториот аргумент е шаблонот кој се користи за да се дешифрира текстот. %[^@]@%s означува шаблон. Во овој случај:
    *    %[^@] означува било кој знак што не е @ (со [^@]) и може да биде било кој број на карактери. Ова го скенира делот пред @.
    *    @ се користи за да го совпадне литералниот @ знак.
    *    %s го скенира секој знак после @ знакот, што е доменот.

    * Следователно, sscanf($email, "%[^@]@%s", $user, $domain) го одделува текстот $email, 
    * го издвојува делот пред @ знакот и го става во променливата $user, а доменот го става во променливата $domain.

    * На крај, методата враќа само доменот на email адресата.
      */

    protected function parseEmail($email)
    {
        sscanf($email, "%[^@]@%s", $user, $domain);
        return $domain;
    }

    /**
     * getMXrecords -> Оваа метода ги добива MX записите за дадениот хост.
     * Влезни параметри: $hostname - името на доменот за кој се бараат MX записите.
     * Излезни параметри: враќа листа на MX записи за дадениот хост.
     */

     /**
      * Оваа метода, getMXrecords(), се користи за да се добијат MX (Mail Exchange) записите за даден домен. MX записите ги дефинираат серверите кои се одговорни за примање и праќање на е-пораки за тој домен.

Еве подетален објаснување на методата:

    Влезни параметри:
        $hostname: Името на доменот за кој се бараат MX записите. На пример, ако сакате да добиете MX записи за доменот example.com, тогаш $hostname би било 'example.com'.

    Излезни параметри:
        Методата враќа листа на MX записи за дадениот хост (домен). Оваа листа е составена од имињата на серверите кои се одговорни за примање и праќање на е-пораки за дадениот домен.

    Објаснување на работата на методата:
        getmxrr() е функција во PHP која се користи за да се добијат MX записите за даден домен. Оваа функција прифаќа име на домен како влезен параметар, и враќа true ако успешно ги добие MX записите, или false во спротивно.
        Ако getmxrr() врати false, тоа значи дека не се пронајдени MX записи за дадениот домен, или се случила грешка при извршувањето на функцијата. Во овој случај, методата поставува грешка соодветно и враќа празна листа на MX записи.
        Ако getmxrr() врати true, тоа значи дека се успешно пронајдени MX записи за дадениот домен. Тие се сортирани според тежината (priority) на серверите за е-пошта, и потоа се враќа листа на MX записи, каде што првиот запис е најпреферираниот сервер за примање на е-пошта.

Примери:

    Ако ја повикате методата getMXrecords('example.com'), каде што 'example.com' е вашиот домен, добивате листа на MX записи за доменот 'example.com'.

    Ако доменот нема MX записи, методата ќе врати празна листа.

    Ако доменот не постои или се случи друга грешка при добивање на MX записите, методата ќе ја постави соодветната грешка и ќе врати празна листа.
      */

      /**
       * MX записите се специфични DNS записи (Mail Exchange) кои се користат за да се одреди кои сервери се одговорни за примање на е-пошта за даден домен. Секој MX запис содржи информации за приоритет на серверот за е-пошта и име на серверот.

Еден MX запис обично содржи два дела:

    Приоритет (Priority): Ова е цел број што го определува редоследот на серверите за е-пошта. Што е помал приоритетниот број, тоа значи дека серверот е понефтин за примање на е-пошта. Кога се испраќа е-пошта до даден домен, прво се обидува да се достави до серверот со најниската вредност на приоритет, ако не успее, тогаш се обидува со следниот сервер во листата.

    Име на серверот (Mail Server): Ова е DNS име на серверот кој е одговорен за примање на е-пошта за дадениот домен.

Пример на MX запис:

10   mail.example.com

Во овој пример:

    Приоритетот е 10.
    Името на серверот за е-пошта е mail.example.com.

Кога се испраќа е-пошта до даден домен, прво се обидува да се достави до серверот mail.example.com. Ако тој сервер не е достапен, тогаш се обидува со следниот сервер со највисок приоритет.
       */

       /**
        * MX записите се со различни приоритети за да се овозможи редослед на обработка на е-поштата и да се осигура непрекинатост на е-поштената услуга.

Кога се испраќа е-пошта до даден домен, прво се обидува да се достави до серверот со најнизок приоритет (највисок број). Ова значи дека серверите со поголем приоритет имаат почетен предностен статус.

Поставување на сервери со различни приоритети им овозможува на администраторите на системите за е-пошта да ги конфигурираат серверите според нивните потреби и способности. На пример, може да има сервери со висок приоритет кои се поставени на осигурување на е-поштата и осигурување на непрекинатост на услугата, додека серверите со помал приоритет може да се користат за извршување на дополнителни функции или за специфични цели.

Друг пример за користење на различни приоритети е кога се користи високопоставен MX запис за осигурување на автоматско преправање на е-поштата кон алтернативен сервер во случај на грешка или недостапност на примарниот сервер. Ова има за цел да се осигура непрекината достава на е-пошта, дури и во случај на проблеми со главниот сервер за е-пошта.
        */

        /**
         * MX records se so razlicen prioritetna vrednost, prvo vo hostname go stavam domainot potoa, 
         * proveruva za toj domaiin dali postoi 
         * se prakaat podatocite i na drug server , prvo so najgolem prioritet so se tie MX values potoa do nasiot server 
         */

    protected function getMXrecords($hostname)
    {
        $mxhosts = [];
        $mxweights = [];
        if (getmxrr($hostname, $mxhosts, $mxweights) === false) {
            $this->setError('MX records not found or an error occurred');
        } else {
            array_multisort($mxweights, $mxhosts);
        }

        if (empty($mxhosts)) {
            $mxhosts[] = $hostname;
        }

        return $mxhosts;
    }

    /**
     *  setError($msg):

     * Оваа метода ја поставува грешката и зголемува бројачот на грешки.
     * Влезни параметри: $msg - пораката за грешката која треба да се прикаже.
     * Излезни параметри: нема, само ја ажурира внатрешната состојба на контролерот.
     */

    protected function setError($msg)
    {
        $this->error_count++;
        $this->error = $msg;
    }

    /**
     * Metoda getError():

     * Оваа метода ја враќа последната поставена грешка.
     * Влезни параметри: нема.
     * Излезни параметри: враќа последната поставена грешка.
     */

    protected function getError()
    {
        return $this->error;
    }

    /**
     * Metoda streamQuery($query):

     * Оваа метода ја испраќа дадената команда преку TCP врската.
     * Влезни параметри: $query - командата која треба да се испрати.
     * Излезни параметри: број на испратени бајти.
     */

    protected function streamQuery($query)
    {
        return stream_socket_sendto($this->stream, $query . "\r\n");
    }

    /**
     * Metoda streamResponse($timed = 0):

     * Оваа метода го чита одговорот од серверот преку TCP врската.
     * Влезни параметри: $timed - време на чекање за одговор (по default е 0).
     * Излезни параметри: враќа одговор од серверот.
     */

    protected function streamResponse($timed = 0)
    {
        $reply = stream_get_line($this->stream, 1);
        $status = stream_get_meta_data($this->stream);

        if (!empty($status['timed_out'])) {
            $this->setError("Timed out while waiting for data! (timeout {$this->stream_timeout} seconds)");
        }

        if ($reply === false && $status['timed_out'] && $timed < $this->stream_timeout_wait) {
            return $this->streamResponse($timed + $this->stream_timeout);
        }

        if ($reply !== false && $status['unread_bytes'] > 0) {
            $reply .= stream_get_line($this->stream, $status['unread_bytes'], "\r\n");
        }

        return $reply;
    }

    /**
     * Metoda streamCode($str):

     * Оваа метода го вади статусниот код од одговорот кој што го добива од серверот.
     * Влезни параметри: $str - одговорот од серверот.
     * 
     * Излезни параметри: враќа статусен код.
     */

    protected function streamCode($str)
    {
        preg_match('/^(?<code>[0-9]{3})(\s|-)(.*)$/ims', $str, $matches);
        $code = isset($matches['code']) ? $matches['code'] : false;
        return $code;
    }
}

