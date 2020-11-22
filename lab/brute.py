#!/usr/bin/env python3

from hashlib import md5


prefix = "ITAC"

for i in range(10000000000):
    hashd = md5(f"{prefix}{i}".encode()).hexdigest()
    if hashd[:2] == 0e and 
        print("win")
        print(f"ITAC{i}")
        break
