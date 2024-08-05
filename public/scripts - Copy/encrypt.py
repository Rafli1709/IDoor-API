import sys
from blowfish import Blowfish

plaintext = sys.argv[1]
key = sys.argv[2]

bf = Blowfish(key)
encryptedText = ""
for i in range(0, len(plaintext), 8):
    encryptedText += bf.encrypt(plaintext[i:i+8])
print(encryptedText)
