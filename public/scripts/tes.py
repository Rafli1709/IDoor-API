import binascii

class Blowfish:
    def __init__(self, key):
        self.P = [] #array_p in blowfish
        self.S = [] #array_s_box in blowfish
        self.generate_subkeys(key)

    def add_trailing_zeros(self, plaintext, length):
        current_length = len(plaintext)

        if current_length % length != 0:
            target_length = ((current_length // length) + 1) * length
            count_characters_to_add = target_length - current_length
            adjusted_plaintext = plaintext + '0' * count_characters_to_add
        else:
            adjusted_plaintext = plaintext

        return adjusted_plaintext

    def remove_trailing_zeros(self, string):
        while string.endswith("00"):
            string = string[:-2]
        return string

    def str_to_hex(self, string):
        return binascii.hexlify(string.encode('latin-1')).decode()

    def hex_to_base10(self, string):
        return int(string, 16)

    def base10_to_hex(self, base10):
        hex_value = ""
        for i in range(7, -1, -1):
            temp_hex = hex((base10 >> (8 * i)) & 0xff)[2:]
            if len(temp_hex) < 2:
                temp_hex = "0" + temp_hex
            hex_value += temp_hex
        return hex_value

    def hex_to_str(self, hex):
        return binascii.unhexlify(hex).decode('latin-1')

    def str_to_base10(self, key, char_len):
        key = self.str_to_hex(key)
        key = self.add_trailing_zeros(key, char_len)
        return self.hex_to_base10(key)

    def generate_subkeys(self, key):
        keyArray = [self.str_to_base10(key[i:i+4], 8) for i in range(0, len(key), 4)]
        lenKeyArray = len(keyArray)

        for i in range(len(self.P)):
            self.P[i] ^= keyArray[i % lenKeyArray]

    def func_f(self, left):
        valueF = self.S[0][left >> 24]
        valueF = (valueF + self.S[1][left >> 16 & 0xff]) % 2**32
        valueF = valueF ^ self.S[2][left >> 8 & 0xff]
        valueF = (valueF + self.S[3][left & 0xff]) % 2**32
        return valueF

    def avalanche_effect(self, plaintext):
        original_ciphertext = self.encrypt(plaintext)

        avalanche_count = 0
        for i in range(len(plaintext) * 8):
            modified_plaintext = bytearray(plaintext.encode('latin-1'))
            modified_plaintext[i // 8] ^= 1 << (i % 8)

            modified_ciphertext = self.encrypt(modified_plaintext)

            for j in range(len(original_ciphertext)):
                xor_result = original_ciphertext[j] ^ modified_ciphertext[j]
                avalanche_count += bin(xor_result).count('1')

        # Calculate the percentage of changed bits
        total_bits = len(plaintext) * 8 * len(original_ciphertext)
        print(avalanche_count)
        print(total_bits)
        #avalanche_effect_percentage = (avalanche_count / total_bits) * 100

        #return avalanche_effect_percentage

    def encrypt(self, plaintext):
        plaintext = self.str_to_base10(plaintext, 16)
        L = plaintext >> 32
        R = plaintext & 0xffffffff

        for i in range(0, 16):
            L = self.P[i] ^ L
            fL = self.func_f(L)
            R ^= fL
            L, R = R, L

        L, R = R, L
        L ^= self.P[17]
        R ^= self.P[16]
        encrypted_data = (L << 32) ^ R
        return self.base10_to_hex(encrypted_data)

    def decrypt(self, chipertext):
        chipertext = self.hex_to_base10(chipertext)
        L = chipertext >> 32
        R = chipertext & 0xffffffff
        for i in range(17, 1, -1):
            L = self.P[i] ^ L
            fL = self.func_f(L)
            R ^= fL
            L, R = R, L
        L, R = R, L
        L ^= self.P[0]
        R ^= self.P[1]
        decrypted_data = (L << 32) ^ R
        decrypted_data = self.base10_to_hex(decrypted_data)
        decrypted_data = self.remove_trailing_zeros(decrypted_data)
        return self.hex_to_str(decrypted_data)

plaintext = "NetvT8KIY1RKOcG2aqy8QnmJhUtzKCqr"
key = "IDR00001"

bf = Blowfish(key)
encryptedText = ""
for i in range(0, len(plaintext), 8):
    encryptedText += bf.encrypt(plaintext[i:i+8])
    bf.avalanche_effect(plaintext[i:i+8])
print(encryptedText)
