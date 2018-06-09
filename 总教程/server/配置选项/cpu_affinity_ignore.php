cpu_affinity_ignore

IO密集型程序中，所有网络中断都是用CPU0来处理，如果网络IO很重，CPU0负载过高会导致网络中断无法及时处理，那网络收发包的能力就会下降。

如果不设置此选项，swoole将会使用全部CPU核，底层根据reactor_id或worker_id与CPU核数取模来设置CPU绑定。

如果内核与网卡有多队列特性，网络中断会分布到多核，可以缓解网络中断的压力
此选项必须与open_cpu_affinity同时设置才会生效

[
    'cpu_affinity_ignore' => [
        0,
        1
    ]
]
接受一个数组作为参数，array(0, 1) 表示不使用CPU0,CPU1，专门空出来处理网络中断。

查看网络中断

[~]$ cat /proc/interrupts
CPU0       CPU1       CPU2       CPU3
0: 1383283707          0          0          0    IO-APIC-edge  timer
1:          3          0          0          0    IO-APIC-edge  i8042
3:         11          0          0          0    IO-APIC-edge  serial
8:          1          0          0          0    IO-APIC-edge  rtc
9:          0          0          0          0   IO-APIC-level  acpi
12:          4          0          0          0    IO-APIC-edge  i8042
14:         25          0          0          0    IO-APIC-edge  ide0
82:         85          0          0          0   IO-APIC-level  uhci_hcd:usb5
90:         96          0          0          0   IO-APIC-level  uhci_hcd:usb6
114:    1067499          0          0          0       PCI-MSI-X  cciss0
130:   96508322          0          0          0         PCI-MSI  eth0
138:     384295          0          0          0         PCI-MSI  eth1
169:          0          0          0          0   IO-APIC-level  ehci_hcd:usb1, uhci_hcd:usb2
177:          0          0          0          0   IO-APIC-level  uhci_hcd:usb3
185:          0          0          0          0   IO-APIC-level  uhci_hcd:usb4
NMI:      11370       6399       6845       6300
LOC: 1383174675 1383278112 1383174810 1383277705
ERR:          0
MIS:          0

eth0/eth1就是网络中断的次数，如果CPU0 - CPU3 是平均分布的，证明网卡有多队列特性。如果全部集中于某一个核，说明网络中断全部由此CPU进行处理，一旦此CPU超过100%，系统将无法处理网络请求。这时就需要使用 cpu_affinity_ignore 设置将此CPU空出，专门用于处理网络中断。

如图上的情况，应当设置 cpu_affinity_ignore => array(0)

可以使用top指令 -> 输入 1，查看到每个核的使用率

<?php
/**
 * Created by PhpStorm.
 * User: hanxiaolong
 * Date: 2018/6/7
 * Time: 11:15
 */