import sys
from blowfish import Blowfish

ciphertext = sys.argv[1]
key = sys.argv[2]

bf = Blowfish(key)
decryptedText = ""
for i in range(0, len(ciphertext), 16):
    decryptedText += bf.decrypt(ciphertext[i:i+16])
print(decryptedText)




