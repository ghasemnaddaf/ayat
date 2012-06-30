#!/usr/bin/python
import codecs
TANZILFILENAME = "quran-simple.txt"
TOTAL_AYATS = 6236
TANZILFILE = codecs.open(TANZILFILENAME, "r", "utf-8")
QURAN = TANZILFILE.readlines()

class Ayat(object):
    '''
    Ayat class. An ayat is a line of Holy Quran. 
    We follow the Tanzil project (http://tanzil.net) conventions.
    '''
    def __init__(self,lineNumber=None):
        'get the ayat from TANZILFILENAME'
        
        if not lineNumber:
            import random
            lineNumber = random.randint(0,TOTAL_AYATS-1)
            
        if lineNumber not in range(TOTAL_AYATS):
            lineNumber = 0
        
        self.lineNumber = lineNumber 
        ln = 0;
        for ayat in QURAN:
            if ln==lineNumber:
                self.Read(ayat)
                break 
            ln+=1

    def Read(self,ayat):
        'read the ayat which is in the following format sooraNumber|ayaNumber|text'        
        S = ayat.split('|')
        self.sooraNumber = int(S[0])
        self.ayaNumber = int(S[1])
        self.location = '%d:%d'%(self.sooraNumber,self.ayaNumber)
        self.linkToTanzil = "http://tanzil.net/#%s"%self.location
        self.text = S[2]
        
    def __repr__(self):
        return "{Soora:Ayat}#"+self.location

ayat = Ayat.Ayat()
print("Content-type", "application/json") #;charset=utf-8")
print(json.dumps(ayat.__dict__).encode("utf-8")) 
