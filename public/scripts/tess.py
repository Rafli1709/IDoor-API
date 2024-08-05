from blowfish import Blowfish

plaintext = 'tes'
print(plaintext)
key = 'IDR00001'
blowfish = Blowfish(key)
encryptedText = blowfish.encrypt(plaintext)
print(encryptedText)
decryptedText = blowfish.decrypt('e67795d852c3f09092a5d744e05b48346830912083bb392bd529cecd6de15b')
print(decryptedText)
