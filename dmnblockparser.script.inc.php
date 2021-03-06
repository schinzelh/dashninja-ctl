<?php

/*
    This file is part of Dash Ninja.
    https://github.com/elbereth/dashninja-ctl

    Dash Ninja is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Dash Ninja is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

 */

if (!defined('DMN_SCRIPT') || !defined('DMN_CONFIG') || (DMN_SCRIPT !== true) || (DMN_CONFIG !== true)) {
  die('Not executable');
}

define('DMN_VERSION','1.0.1');

xecho('dmnblockparser v'.DMN_VERSION."\n");

xecho('Retrieving nodes for this hub: ');
$result = dmn_cmd_get('/nodes',array(),$response);
if ($response['http_code'] == 200) {
  echo "Fetched...";
  $nodes = json_decode($result,true);
  if ($nodes === false) {
    echo " Failed to JSON decode!\n";
    die(200);
  }
  elseif (!is_array($nodes) || !array_key_exists('data',$nodes) || !is_array($nodes['data'])) {
    echo " Incorrect data!\n";
    die(202);
  }
  $nodes = $nodes['data'];
  echo " OK (".count($nodes)." entries)\n";
}
else {
  echo "Failed [".$response['http_code']."]\n";
  if ($response['http_code'] != 500) {
    $result = json_decode($result,true);
    if ($result !== false) {
      foreach($result['messages'] as $num => $msg) {
        xecho("Error #$num: $msg\n");
      }
    }
  }
  die(201);
}

xecho('Retrieving masternode pubkeys: ');
$result = dmn_cmd_get('/masternodes/pubkeys',array(),$response);
if ($response['http_code'] == 200) {
  echo "Fetched...";
  $mnpubkeys = json_decode($result,true);
  if ($mnpubkeys === false) {
    echo " Failed to JSON decode!\n";
    die(200);
  }
  elseif (!is_array($mnpubkeys) || !array_key_exists('data',$mnpubkeys) || !is_array($mnpubkeys['data'])
       || !array_key_exists('mnpubkeys',$mnpubkeys['data']) || !is_array($mnpubkeys['data']['mnpubkeys'])) {
    echo " Incorrect data!\n";
    die(202);
  }
  $mnpubkeys = $mnpubkeys['data']['mnpubkeys'];
  echo " OK (".count($mnpubkeys)." entries)\n";
}
else {
  echo "Failed [".$response['http_code']."]\n";
  if ($response['http_code'] != 500) {
    $result = json_decode($result,true);
    if ($result !== false) {
      foreach($result['messages'] as $num => $msg) {
        xecho("Error #$num: $msg\n");
      }
    }
  }
  die(202);
}

xecho('Retrieving masternode donations pubkeys: ');
$result = dmn_cmd_get('/masternodes/donations',array(),$response);
if ($response['http_code'] == 200) {
  echo "Fetched...";
  $mndonations = json_decode($result,true);
  if ($mndonations === false) {
    echo " Failed to JSON decode!\n";
    die(200);
  }
  elseif (!is_array($mndonations) || !array_key_exists('data',$mndonations) || !is_array($mndonations['data'])
       || !array_key_exists('mndonations',$mndonations['data']) || !is_array($mndonations['data']['mndonations'])) {
    echo " Incorrect data!\n";
    die(202);
  }
  $mndonations = $mndonations['data']['mndonations'];
  echo " OK (".count($mndonations)." entries)\n";
}
else {
  echo "Failed [".$response['http_code']."]\n";
  if ($response['http_code'] != 500) {
    $result = json_decode($result,true);
    if ($result !== false) {
      foreach($result['messages'] as $num => $msg) {
        xecho("Error #$num: $msg\n");
      }
    }
  }
  die(204);
}

xecho('Retrieving pools pubkeys: ');
$result = dmn_cmd_get('/pools',array(),$response);
if ($response['http_code'] == 200) {
  echo "Fetched...";
  $poolpubkeys = json_decode($result,true);
  if ($poolpubkeys === false) {
    echo " Failed to JSON decode!\n";
    die(200);
  }
  elseif (!is_array($poolpubkeys) || !array_key_exists('data',$poolpubkeys) || !is_array($poolpubkeys['data'])
       || !array_key_exists('poolpubkeys',$poolpubkeys['data']) || !is_array($poolpubkeys['data']['poolpubkeys'])) {
    echo " Incorrect data!\n";
    die(202);
  }
  $poolpubkeys = $poolpubkeys['data']['poolpubkeys'];
  echo " OK (".count($mnpubkeys)." entries)\n";
}
else {
  echo "Failed [".$response['http_code']."]\n";
  if ($response['http_code'] != 500) {
    $result = json_decode($result,true);
    if ($result !== false) {
      foreach($result['messages'] as $num => $msg) {
        xecho("Error #$num: $msg\n");
      }
    }
  }
  die(203);
}

xecho('Retrieving superblocks expected: ');
$result = dmn_cmd_get('/budgetsexpected',array(),$response);
if ($response['http_code'] == 200) {
  echo "Fetched...";
  $mnsuperblocks = json_decode($result,true);
  if ($mnsuperblocks === false) {
    echo " Failed to JSON decode!\n";
    die(210);
  }
  elseif (!is_array($mnsuperblocks) || !array_key_exists('data',$mnsuperblocks) || !is_array($mnsuperblocks['data'])
      || !array_key_exists('budgetsexpected',$mnsuperblocks['data']) || !is_array($mnsuperblocks['data']['budgetsexpected'])) {
    echo " Incorrect data!\n";
    die(212);
  }
  $mnsuperblocks = $mnsuperblocks['data']['budgetsexpected'];
  echo " OK (".count($mnsuperblocks)." entries)\n";
}
else {
  echo "Failed [" . $response['http_code'] . "]\n";
  if ($response['http_code'] != 500) {
    $result = json_decode($result, true);
    if ($result !== false) {
      foreach ($result['messages'] as $num => $msg) {
        xecho("Error #$num: $msg\n");
      }
    }
  }
  die(214);
}

function dmn_blockparse($uname, $testnet, $mnpubkeys, $mndonations, $poolpubkeys, $mnsuperblocks, &$bhws, &$bws, &$btarchive, &$blockarchive, &$txarchive) {

  xecho("==> Processing $uname: ");
  if (!is_dir("/dev/shm/$uname")) {
    echo "Error 1\n";
    return false;
  }
  $canparseblocks = is_dir("/dev/shm/$uname/tx");
  $canparseblocktemplates = is_dir("/dev/shm/$uname/bt");
  if (!$canparseblocks && !$canparseblocktemplates) {
    echo "Error 2\n";
    return false;
  }
  if (!is_dir(DMN_BLOCKPARSER_ARCHIVE.$uname.'/') || !is_dir(DMN_BLOCKPARSER_ARCHIVE.$uname.'/tx/')) {
    mkdir(DMN_BLOCKPARSER_ARCHIVE.$uname.'/tx/',0700,true);
  }
  if (!is_dir(DMN_BLOCKPARSER_ARCHIVE.$uname.'/bt/')) {
    mkdir(DMN_BLOCKPARSER_ARCHIVE.$uname.'/bt/',0700,true);
  }
  echo "OK\n";

  xecho(" Retrieving available block template files: ");
  $btfiles = array();
  if ($canparseblocktemplates) {
    if ($handle = opendir("/dev/shm/$uname/bt/")) {
      while (false !== ($entry = readdir($handle))) {
        if (is_file("/dev/shm/$uname/bt/$entry")) {
          if ((strlen($entry) > 19) && (substr($entry,0,14) == 'blocktemplate.') && (substr($entry,-5) == '.json')) {
            $btfiles[] = $entry;
          }
        }
      }
      closedir($handle);
    }
    if (count($btfiles) == 0) {
      echo "None found\n";
    }
    else {
      echo "OK (".count($btfiles)." files)\n";
    }
    sort($btfiles);
  }
  else {
    echo "Folder not found\n";
  }

  xecho(" Retrieving available block files: ");
  $txfiles = array();
  $blockfiles = array();
  if ($canparseblocks) {
    if ($handle = opendir("/dev/shm/$uname/")) {
      while (false !== ($entry = readdir($handle))) {
        if (is_file("/dev/shm/$uname/$entry")) {
          if ((strlen($entry) > 11) && (substr($entry,0,6) == 'block.') && (substr($entry,-5) == '.json')) {
            $blockfiles[] = $entry;
          }
        }
      }
      closedir($handle);
    }
    if (count($blockfiles) == 0) {
      echo "None found\n";
    }
    else {
      echo "OK (".count($blockfiles)." files)\n";
    }

    xecho(" Retrieving available transaction files: ");
    if ($handle = opendir("/dev/shm/$uname/tx/")) {
      while (false !== ($entry = readdir($handle))) {
        if (is_file("/dev/shm/$uname/tx/$entry")) {
          if ((strlen($entry) > 17) && (substr($entry,0,12) == 'transaction.') && (substr($entry,-5) == '.json')) {
            $txfiles[] = $entry;
          }
        }
      }
      closedir($handle);
    }
    if (count($txfiles) == 0) {
      echo "None found\n";
    }
    else {
      echo "OK (".count($txfiles)." files)\n";
    }
    sort($blockfiles);
    sort($txfiles);
  }
  else {
    echo "Folder not found\n";
  }

  if ((count($txfiles) == 0) && (count($btfiles) == 0)) {
    return true;
  }

  if (count($btfiles) > 0) {
    xecho(" Parsing block templates:\n");
    $btprotocol = 0;
    foreach($btfiles as $btfile) {
      $blockid = substr($btfile,14,strlen($btfile)-19);
      if (substr_count($blockid,'_') == 2) {
        $pos1 = strpos($blockid,'_');
        $pos2 = strrpos($blockid,'_');
        $btprotocol = substr($blockid,$pos1+1,$pos2-$pos1-1);
        $btversion = substr($blockid,$pos2+1);
        $blockid = substr($blockid,0,$pos1);
        xecho("  Block template $blockid (pv=$btprotocol v=$btversion): ");
        $bt = json_decode(file_get_contents("/dev/shm/$uname/bt/$btfile"),true);
        if (($bt !== false) && isset($bt) && array_key_exists('payee',$bt)) {
          echo $bt['payee']."\n";
          if (array_key_exists('payee_amount',$bt) && array_key_exists('coinbasevalue',$bt)) {
            $btpam = $bt['payee_amount']/$bt['coinbasevalue'];
          } else {
            $btpam = 0.2;
          }
          $bhws[] = array("BlockHeight" => $blockid,
                          "BlockTestNet" => $testnet,
                          "FromNodeUserName" => $uname,
                          "BlockMNPayee" => $bt['payee'],
                          "LastUpdate" => date('Y-m-d H:i:s',$bt['curtime']),
                          "Protocol" => $btprotocol,
                          "BlockMNRatio" => $btpam);
          $btarchive["/dev/shm/$uname/bt/$btfile"] = DMN_BLOCKPARSER_ARCHIVE.$uname.'/bt/'.$btfile;
        }
        else {
          echo "Incorrect format\n";
        }
      }
    }
  }

  $blockidlow = -1;
  $blockidhigh = -1;

  if ((count($blockfiles) > 0) && (count($txfiles) > 0)) {
    xecho(" Parsing blocks:\n");
    foreach($blockfiles as $blockfile) {
      $blockid = substr($blockfile,6,strlen($blockfile)-11);
      xecho("  Block $blockid: ");
      $block = json_decode(file_get_contents("/dev/shm/$uname/$blockfile"),true);
      if (($block !== false) && isset($block) && array_key_exists('height',$block)) {
        if ($block['height'] == $blockid) {
          if (($blockidlow == -1) || ($blockid < $blockidlow)) {
            $blockidlow = $blockid;
          }
          if (($blockidhigh == -1) || ($blockid > $blockidhigh)) {
            $blockidhigh = $blockid;
          }
          if (array_key_exists($blockid,$mnsuperblocks[$testnet])) {
            $issuperblock = 1;
          }
          else {
            $issuperblock = 0;
          }
          $blockarchive["/dev/shm/$uname/$blockfile"] = DMN_BLOCKPARSER_ARCHIVE.$uname.'/'.$blockfile;
          $gentx = false;
          foreach($block['tx'] as $txid => $txhash) {
            if (in_array("transaction.$txhash.json",$txfiles)) {
              $txarchive["/dev/shm/$uname/tx/transaction.$txhash.json"] = DMN_BLOCKPARSER_ARCHIVE.$uname.'/tx/'."transaction.$txhash.json";
              if (!$gentx) {
                $tx = json_decode(file_get_contents("/dev/shm/$uname/tx/transaction.$txhash.json"),true);
                if (array_key_exists('vin',$tx) && is_array($tx['vin']) && (count($tx['vin']) == 1) && is_array($tx['vin'][0]) && array_key_exists('coinbase',$tx['vin'][0])) {
                  $gentx = true;
                  $outcheck = array();
                  $total = 0;
                  foreach($tx['vout'] as $voutid => $vout) {
                    if (array_key_exists('scriptPubKey',$vout) && is_array($vout['scriptPubKey']) && array_key_exists('addresses',$vout['scriptPubKey']) && (count($vout['scriptPubKey']['addresses']) == 1)) {
                      if (array_key_exists($vout['scriptPubKey']['addresses'][0],$outcheck)) {
                        $outcheck[$vout['scriptPubKey']['addresses'][0]] += $vout['value'];
                      }
                      else {
                        $outcheck[$vout['scriptPubKey']['addresses'][0]] = $vout['value'];
                      }
                      $total += $vout['value'];
                    }
                  }
                  if ($testnet == 1) {
                    $mntest1 = ($total*0.5);
                    $mntest1from = $mntest1-($mntest1*0.001);
                    $mntest1to = $mntest1+($mntest1*0.001);
                    $mntest2 = ($total*0.475);
                    $mntest2from = $mntest2-($mntest2*0.001);
                    $mntest2to = $mntest2+($mntest2*0.001);
                  }
                  else {
                    $mntest1 = ($total*0.5);
                    $mntest1from = $mntest1-($mntest1*0.001);
                    $mntest1to = $mntest1+($mntest1*0.001);
                    $mntest2 = ($total*0.475);
                    $mntest2from = $mntest2-($mntest2*0.001);
                    $mntest2to = $mntest2+($mntest2*0.001);
                  }
                  $mnpayee = false;
                  $mnpaid = 0;
                  $mnpaidok = 0;
                  $pooladdr = '';
                  $pooladdrnum = 0;
                  $poolpaidlast = 0;
                  $foundinlist = false;
                  $mnpayeedonation = 0;
                  $superblockbudgetname = "";
                  foreach($outcheck as $address => $value) {
                    if (($issuperblock == 1) && ($address == $mnsuperblocks[$testnet][$blockid]["PaymentAddress"])) {
                      $mnpayee = $address;
                      $mnpaid = $value;
                      if ($mnpaid == $mnsuperblocks[$testnet][$blockid]["MonthlyPayment"]) {
                        $mnpaidok = 1;
                      }
                      else {
                        $mnpaidok = 0;
                      }
                      $mnpayeedonation = 0;
                      $superblockbudgetname = $mnsuperblocks[$testnet][$blockid]["BlockProposal"];
                    }
                    elseif (($issuperblock == 0) && array_key_exists($address,$mnpubkeys)) {
                      $mnpayee = $address;
                      $mnpaid = $value;
                      $mnpaidok = 1;
                      $mnpayeedonation = 0;
                    }
                    elseif (($issuperblock == 0) && array_key_exists($address,$mndonations)) {
                      $mnpayee = $address;
                      $mnpaid = $value;
                      $mnpaidok = 1;
                      $mnpayeedonation = 1;
                    }
/*                    elseif (($issuperblock == 0) && ($mnpaidok != 1) &&
                             ((($value >= $mntest1from) && ($value <= $mntest1to)) ||
                              (($value >= $mntest2from) && ($value <= $mntest2to)))) {
                      $mnpayee = $address;
                      $mnpaid = $value;
                      $mnpaidok = 1;
                      $mnpayeedonation = 0;
                      echo "MASTERNODE GUESS";
                    }*/
                    else {
                      if ($poolpaidlast <= $value) {
                        $poolpaidlast = $value;
                        $pooladdr = $address;
                        $foundinlist = array_key_exists($address,$poolpubkeys);
                      }
                      $pooladdrnum++;
                    }
                  }
                  echo $pooladdr." - ";
                  if (($pooladdrnum > 2) && (!$foundinlist)) {
                    $pooladdr = "P2POOL";
                  }
                  if ($mnpayee !== false) {
                    if (array_key_exists($mnpayee,$mnpubkeys)) {
                      $protocol = $mnpubkeys[$mnpayee];
                    }
                    else {
                      $protocol = 0;
                    }
                    $bws[] = array("BlockTestNet" => $testnet,
                                   "BlockId" => $blockid,
                                   "BlockHash" => $block['hash'],
                                   "BlockMNPayee" => $mnpayee,
                                   "BlockMNValue" => $mnpaid,
                                   "BlockSupplyValue" => $total,
                                   "BlockMNPayed" => 1,
                                   "BlockPoolPubKey" => $pooladdr,
                                   "BlockMNProtocol" => $protocol,
                                   "BlockTime" => $block['time'],
                                   "BlockDifficulty" => $block['difficulty'],
                        "BlockMNPayeeDonation" => $mnpayeedonation,
                        "IsSuperblock" => $issuperblock,
                        "SuperblockBudgetName" => $superblockbudgetname,
                        );
                    echo "$mnpayee ($mnpaid DASH)\n";
                  }
                  else {
                    $bws[] = array("BlockTestNet" => $testnet,
                                   "BlockId" => $blockid,
                                   "BlockHash" => $block['hash'],
                                   "BlockMNPayee" => '',
                                   "BlockMNValue" => 0.0,
                                   "BlockSupplyValue" => $total,
                                   "BlockMNPayed" => 0,
                                   "BlockPoolPubKey" => $pooladdr,
                                   "BlockMNProtocol" => 0,
                                   "BlockTime" => $block['time'],
                                   "BlockDifficulty" => $block['difficulty'],
                                   "BlockMNPayeeDonation" => 0,
                        "IsSuperblock" => $issuperblock,
                        "SuperblockBudgetName" => $superblockbudgetname,
                        );
                    echo "Unpaid\n";
                  }
                }
              }
            }
          }
          if ($gentx === false) {
            echo "No generation TX found!\n";
          }
        }
        else {
          echo "Height mismatch ($blockid / ".$block['height'].")\n";
          unlink("/dev/shm/$uname/$blockfile");
        }
      }
      else {
        echo "Error\n";
        unlink("/dev/shm/$uname/$blockfile");
      }
    }
  }

  return true;
}

$btarchive = array();
$blockarchive = array();
$txarchive = array();

$bws = array();
$bhws = array();

foreach($nodes as $node) {
  dmn_blockparse($node['NodeName'], $node['NodeTestNet'], $mnpubkeys, $mndonations, $poolpubkeys, $mnsuperblocks, $bhws, $bws, $btarchive, $blockarchive, $txarchive);
}

if ((count($bhws) > 0) || (count($bws) > 0)) {
  $payload = array('blockshistory' => $bhws,
                   'blocksinfo' => $bws);

  xecho("Submitting via webservice: ");
  $response = '';
  $content = dmn_cmd_post('/blocks',$payload,$response);

  if ($response['http_code'] == 202) {
    $content = json_decode($content,true);
    echo "OK (BH=".$content['data']['blockshistory']."/BI=".$content['data']['blocksinfo']."/MI=".$content['data']['mninfo'].")\n";
  }
  else {
    echo "Failed [".$response['http_code']."]\n";
    if ($response['http_code'] != 500) {
      $result = json_decode($content,true);
      if ($result !== false) {
        foreach($result['messages'] as $num => $msg) {
          xecho("Error #$num: $msg\n");
        }
      }
    }
    die();
  }
}

if ((count($blockarchive)+count($btarchive)) > 0)  {
  xecho("Archiving treated files: ");
  if (count($blockarchive) > 0) {
    foreach($blockarchive as $filename => $archivename) {
      rename($filename,$archivename);
    }
    echo count($blockarchive)." block files... ";
    foreach($txarchive as $filename => $archivename) {
      rename($filename,$archivename);
    }
    echo count($txarchive)." transaction files... ";
  }
  if (count($btarchive) > 0) {
    foreach($btarchive as $filename => $archivename) {
      rename($filename,$archivename);
    }
    echo count($btarchive)." block template files... ";
  }
  echo "\n";
}

?>
