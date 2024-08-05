import sys
from blowfish import Blowfish

plaintext = sys.argv[1]
key = sys.argv[2]

bf = Blowfish(key)

avalanche_count = 0
total_bits = 0

for i in range(0, len(plaintext), 8):
    a, b = bf.avalanche_effect(plaintext[i:i+8])
    avalanche_count += a
    total_bits += b

avalanche_effect_percentage = (avalanche_count / total_bits) * 100

print(avalanche_effect_percentage)
