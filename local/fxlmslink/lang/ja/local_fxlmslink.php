<?php
// This file is part of fxlmslink moodle plugin - http://www.fujixerox.co.jp
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local plugin "fxlmslink" - Library
 *
 * @package     fxlmslink
 * @copyright   2014 Fuji Xerox Co., Ltd.
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

$string['pluginname'] = '授業支援ボックス';
$string['teacheridfield'] = '教員番号フィールド';
$string['teacheridfielddesc'] = 'このフィールドを教員番号として扱います。';
$string['studentidfield'] = '学籍番号フィールド';
$string['studentidfielddesc'] = 'このフィールドを学籍番号として扱います。';
$string['allowips'] = '許可IP';
$string['allowipsdesc'] = 'アクセスを許可する機器のIPアドレスを１行に１つずつ記載してください。';
$string['defer'] = '保留領域を使用する';
$string['deferdesc'] = '授業支援ボックスからの提出を直接登録せずに保留領域に格納します。';

$string['replacement'] = 'ファイル差し替え';
$string['finishsubmissions'] = 'ファイル提出と評点を登録する';
$string['cancelsubmissions'] = 'ファイル提出と評点を削除する';
$string['nodeferredsubmissions'] = '提出保留中のデータはありません';
$string['confirmationremoved'] = 'すべての提出を削除します。';

$string['webserver'] = 'Webサーバ';
$string['notokens'] = 'トークンが作成されていません。';
$string['authority'] = 'ユーザーの権限をチェックする';
$string['authoritydesc'] = 'ケイパビリティの「授業支援ボックスからの操作を許可する」に従ってアクセスを制御します。
<br />サイト管理者は設定に関わらずアクセスできます。
<br />ゲストアカウントは設定に関わらずアクセスできません。
<br />フロントページの認証済みユーザのケイパビリティを有効にすると、
<br />認証済みユーザも有効になります。なお、ケイパビリティの継承はmoodleの仕様に従います。';
$string['authorityno'] = 'しない';
$string['authorityyes'] = 'する';
$string['fxlmslink:enabled_fxlmslink'] = '授業支援ボックスからの操作を許可する';
$string['no'] = 'いいえ';
$string['yes'] = 'はい';
