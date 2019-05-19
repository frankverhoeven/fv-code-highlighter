<?php

declare(strict_types=1);

namespace FvCodeHighlighter\Highlighter\Bash;

use FvCodeHighlighter\Highlighter\AbstractHighlighter;

final class Bash extends AbstractHighlighter
{
    /** @var string[] List of common commands */
    public static $commands = [
        'alias',
        'apropos',
        'apt-get',
        'aptitude',
        'aspell',
        'awk',
        'basename',
        'bash',
        'bc',
        'bg',
        'bind',
        'break',
        'builtin',
        'bzip2',
        'cal',
        'case',
        'cat',
        'cd',
        'cfdisk',
        'chattr',
        'chgrp',
        'chmod',
        'chown',
        'chroot',
        'chkconfig',
        'cksum',
        'clear',
        'cmp',
        'comm',
        'command',
        'continue',
        'cp',
        'cron',
        'crontab',
        'csplit',
        'curl',
        'cut',
        'date',
        'dc',
        'dd',
        'ddrescue',
        'declare',
        'df',
        'diff',
        'diff3',
        'dig',
        'dir',
        'dircolors',
        'dirname',
        'dirs',
        'dmesg',
        'du',
        'echo',
        'egrep',
        'eject',
        'enable',
        'env',
        'ethtool',
        'eval',
        'exec',
        'exit',
        'expect',
        'expand',
        'export',
        'expr',
        'false',
        'fdformat',
        'fdisk',
        'fg',
        'fgrep',
        'file',
        'find',
        'fmt',
        'fold',
        'for',
        'format',
        'free',
        'fsck',
        'ftp',
        'function',
        'fuser',
        'gawk',
        'getopts',
        'grep',
        'groupadd',
        'groupdel',
        'groupmod',
        'groups',
        'gzip',
        'hash',
        'head',
        'help',
        'history',
        'hostname',
        'htop',
        'iconv',
        'id',
        'if',
        'ifconfig',
        'ifdown',
        'ifup',
        'import',
        'install',
        'iostat',
        'ip',
        'jobs',
        'join',
        'kill',
        'killall',
        'less',
        'let',
        'link',
        'ln',
        'local',
        'locate',
        'logname',
        'logout',
        'look',
        'lpc',
        'lpr',
        'lprint',
        'lprintd',
        'lprintq',
        'lprm',
        'lsattr',
        'lsblk',
        'ls',
        'lsof',
        'make',
        'man',
        'mkdir',
        'mkfifo',
        'mkisofs',
        'mknod',
        'more',
        'most',
        'mount',
        'mtools',
        'mtr',
        'mv',
        'mmv',
        'nc',
        'netstat',
        'nice',
        'nl',
        'nohup',
        'notify-send',
        'nslookup',
        'open',
        'op',
        'passwd',
        'paste',
        'pathchk',
        'ping',
        'pgrep',
        'pkill',
        'popd',
        'pr',
        'printcap',
        'printenv',
        'printf',
        'ps',
        'pushd',
        'pv',
        'pwd',
        'quota',
        'quotacheck',
        'ram',
        'rar',
        'rcp',
        'read',
        'readarray',
        'readonly',
        'reboot',
        'rename',
        'renice',
        'remsync',
        'return',
        'rev',
        'rm',
        'rmdir',
        'rsync',
        'screen',
        'scp',
        'sdiff',
        'sed',
        'select',
        'seq',
        'set',
        'sftp',
        'shift',
        'shopt',
        'shutdown',
        'sleep',
        'slocate',
        'sort',
        'source',
        'split',
        'ss',
        'ssh',
        'stat',
        'strace',
        'su',
        'sudo',
        'sum',
        'suspend',
        'sync',
        'tail',
        'tar',
        'tee',
        'test',
        'time',
        'timeout',
        'times',
        'touch',
        'top',
        'tput',
        'traceroute',
        'trap',
        'tr',
        'true',
        'tsort',
        'tty',
        'type',
        'ulimit',
        'umask',
        'umount',
        'unalias',
        'uname',
        'unexpand',
        'uniq',
        'units',
        'unrar',
        'unset',
        'unshar',
        'until',
        'uptime',
        'useradd',
        'userdel',
        'usermod',
        'users',
        'uuencode',
        'uudecode',
        'v',
        'vdir',
        'vi',
        'vmstat',
        'wait',
        'watch',
        'wc',
        'whereis',
        'which',
        'while',
        'who',
        'whoami',
        'wget',
        'write',
        'xargs',
        'xdg-open',
        'xz',
        'yes',
        'zip',
    ];
}
