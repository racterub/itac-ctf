#!/usr/bin/env python3

import random

f = open("sample", "w")

flag_format = "ITAC{}"
realflag = "ITAC{grep_with_regex_is_useful_for_searching_in_large_data}"


def gen_trash(f):
    for i in range(10):
    #for i in range(random.randint(100420, 140204)):
        f.write(flag_format[0:random.randint(1, 5)])


gen_trash(f)
f.write(realflag)
gen_trash(f)

f.close()


