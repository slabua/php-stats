<?php
if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
if(isset($_GET['q'])) $q=addslashes($_GET['q']); else $q="unknown";
header('Content-Type: image/gif');
echo base64_decode(image("$q")); 
exit; 
function image($tag) {

$tmp="R0lGODlhDgAOA";
if($tag=="ac") $tmp.="LMAAJSaz+GxAWtXSGqBYqqSt/O2ui5LqoQwa05KjxoeKE0cbN5EU9p5iSIUfP4qKQAAfiH5BAAAAAAALAAAAAAOAA4AAAQ/8DCzjmLt6W1YYR6QbZpjno5CluiyqI0gaAZQLB6iKUGQEZgKAvNoDAaaQ0aRQYwQhpX0kUhMV9WrdsvterURADs=";
elseif($tag=="ad") $tmp.="LMAAPJmBNu+BLy8DPJxBOflBN/UBO3sBP5WBF1dO/38BAICZP4CBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ7UEmFkk1n6TXpxRs3VVe2dZVhgOdIFAVhaqiADMUsSogNBDpU4ScLCYnBkUqV5KkIhqanZBx9pCSLLgIAOw==";
elseif($tag=="ae") $tmp.="KIAAP7CvEJyBE6uUlpUUv7+/AKVDP4MBAcCBCH5BAAAAAAALAAAAAAOAA4AAAMtaBrV/sqwR+OkzmK4hP9gBBBkaYpmSqBqybarMsx0PURHru8HzvO+ny4oPCQAADs=";
elseif($tag=="af") $tmp.="KIAAJnfLJ6eJGxsFGnOWzAwJwsLCwWuBf392CH5BAAAAAAALAAAAAAOAA4AAAMqaLrc/jCuAdy4F2R8j/9gKI5kaR5EmgpCIKhpIcvvO994ru9xQcg/HzABADs=";
elseif($tag=="ag") $tmp.="KIAAPFqYV0DBJaaD/KTlOjpmSNcjgkJB/cNCyH5BAAAAAAALAAAAAAOAA4AAAM0aLrM0UW0cJggRK5znikYVigUp1yYMBocV7ww3LZxPLt1cbchNuycQQ/I8xGDmCMPoAwCEwA7";
elseif($tag=="ai") $tmp.="LMAAO9FR2ZlsdNpbkQrguTIzpaRvmBFkKtzkp5NcL4CBNWIkAMDfwAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ+UIWF0BpqrL2HKJWhGBx3KIoAoEe5JXAMu8uZCoTSbsRRBKMKULNRAAoHUmVh2C0IR5qLQChIr9hOdsvtbiMAOw==";
elseif($tag=="al") $tmp.="KIAAMsCBFUCBKoCBHUCBIkCBBECBOEbHfwEBiH5BAAAAAAALAAAAAAOAA4AAAMvaLfc/k/BecAQYoAmDxlBMBATUZwFyXQmOpRoyjFEO05AWFxzg1HAQwdoKBqPxwQAOw==";
elseif($tag=="am") $tmp.="KIAAK4WRKYaTBZKvBZGvP4CBAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMhSLrc/jBKAqq9d+jNt/hgCA5CZ5LaSJZlGrxwHE90bTsJADs=";
elseif($tag=="an") $tmp.="KIAACIitI5GhDo6vNpubKam5LACDwMDrP7+/CH5BAAAAAAALAAAAAAOAA4AAAMyeKpTNSuu9qSk0E6XF/lf4ATgZ5woAKAsK5xvK88tIAgrWxJiQZYXjmZTGR4wxqMwkgAAOw==";
elseif($tag=="ao") $tmp.="KIAAGFMCnxjBlY3DN1uFM6XCEsZEeZFHxQHCSH5BAAAAAAALAAAAAAOAA4AAAMxaLrc/m4Q2CQ1dlI7BisgKIRDWBwoSpwFkL5oQRyBC6MBLtxpQBC1HQ8mEA5TpyMvAQA7";
elseif($tag=="aq") $tmp.="KIAANXq/M7m/JbK/HO5/KnV/Fms/Pz9/DOa/CH5BAAAAAAALAAAAAAOAA4AAAMueLrcXcU9Q0mUhGqyBi+aBjBBaDKguS2CqgVLAbgGvGTu8AyeKCkpw+XH+xkPCQA7";
elseif($tag=="ar") $tmp.="KIAAAC9/VHS/f7+/v///wC+/QC9/AAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMmSLrMBa9ESUu7q2oduv+fII5kOYzDWQpp675rLIC0t0Ebhm18zycAOw==";
elseif($tag=="arpa") $tmp.="IAAAAAAAP///yH5BAAAAAAALAAAAAAOAA4AAAIajI8JqbccnmMS1doitBiCnoHG5VGZOW6pmhQAOw==";
elseif($tag=="as") $tmp.="LMAAOnYAmFCAMbGwv/Pz9wMGpdgCGQbJMp3EBIMAhAxhP8AAAgpe////wAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARCcMlJp6oyaaUY06AmcczxhdvglQxldGuJCEtCxl4QMDfuFaZFzxesDT0CQCuTIMBwFREMoIwmLKrlRGTpIL7gcDgCADs=";
elseif($tag=="at") $tmp.="KIAAPZSVPb29P5WVPZGRPYCBP7+/P4CBAAAACH5BAAAAAAALAAAAAAOAA4AAAMnSLbcS8pJKGesjIzNew9FKI5kSQagOaLqCghwLMPAhRnU/dhYrhMJADs=";
elseif($tag=="au") $tmp.="KIAAPbg5NyvwtVcZ94JC2ZfuNGMok0ojgYGmyH5BAAAAAAALAAAAAAOAA4AAAM3WHRyVidKp8RbM5ISBIeaNIzkkEVCUAxqcxqBIWyGExlLUVvbgZ1AW3B4ABEPgNoxcPoRlcdJAgA7";
elseif($tag=="aw") $tmp.="KIAAGYWrFISvCYO5D4S1NIOPDo6xP76HAIC/CH5BAAAAAAALAAAAAAOAA4AAAMdeLrcJ8C1QUiQi1q8IP9gKIJGaZ5noa4si77mOCYAOw==";
elseif($tag=="az") $tmp.="LMAAP7W0P6OfHKEQP5pUP708v6biv5TOHNSHXYujP4pBwIx+gNxBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ0UMlJq704a4V6P16IJGQBDKRBriuhJgURsCmBwjJdnurwkofgQSAQGg+LpHLJbDqf0OgiAgA7";
elseif($tag=="ba") $tmp.="KIAAEhI1A0NyfSLlP56enDFbv4CBAObBfr6+yH5BAAAAAAALAAAAAAOAA4AAAM7WDrXTiaqItyLZlZCxMYTYxADA0nLAZUqmHJei1JWc2ZpoAcyTgM6QE+j0hGGqQPQ5qLVbqEa0mm5JQAAOw==";
elseif($tag=="bb") $tmp.="KIAAJZ0Vt69HLKOPcalLWtHe4pkX/bXCUwkjyH5BAAAAAAALAAAAAAOAA4AAAM7eHpkbmXJUx6cqz2AlR5XRwgDIESiYJQoRgTBcHaMIZDt1BTEkEuNgOqXMcRCmMqD6LHkCAyKI4AkJAAAOw==";
elseif($tag=="bd") $tmp.="KIAAJw2BDJkBE1YBBtvBGdPBOYWBP4MBAJ6BCH5BAAAAAAALAAAAAAOAA4AAAMveLrcPEQ4RowtYVbLhyscBzRByBXNZhreopqtUq5oA5pjI5hFTJ2ZyWEgkAiPigQAOw==";
elseif($tag=="be") $tmp.="KIAAPpIBPVHBFFCBPECBPrRBPXQBPgCBAICBCH5BAAAAAAALAAAAAAOAA4AAAM7eHpSXmHIsdiDJtPVCiFBZmxKQziASFofplXC6YUv580qfJ70qHugnE2WqpWALh9HRigqS63kquOITBIAOw==";
elseif($tag=="bf") $tmp.="LMAAPZXBPaoBPqOBLScBFagBPbiBJ7GBCaCBPT2BK4jBPcCBANwBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQtUMlJq704U6Bn0YAQIIHASUmaDkg7qMkiy0dbzPhMGIdB5LjDTAgsGo/IpDECADs=";
elseif($tag=="bg") $tmp.="KIAAMZCHP4OBL7evP4KBP7+/FaqVAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMmSLrc/jBKIqq9t+jNu/9gKBZAaZ7noK7sGrTw8KpB3b61TdO4mgAAOw==";
elseif($tag=="bh") $tmp.="KIAAPXQ0PhVVvWKivgZGvc7Ovi0tPj39/cCBCH5BAAAAAAALAAAAAAOAA4AAAMqaApC9/ApU8KIcVKHpSrE1R0aOJKfdU4M17HNmorvZI62W396NsuG1ikBADs=";
elseif($tag=="bi") $tmp.="LMAAM7OnM4xMc6cnM7Ozv//zu/v75zOnP+cnGNjY////84xADGcAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARMEKWkqrUTlXSuPUmBLFt3gcUyLkaYCK6xqDM7KZM8r/M0TDVabUIM8haUpLHWAiScOmFrM9noRgROJVABEVRZk8croXgwCYR6zWZHAAA7";
elseif($tag=="bj") $tmp.="KIAAN4AAABjAO8AAP/eAABrAP8AAP//AABzACH5BAAAAAAALAAAAAAOAA4AAAMrSLdr/k6xA6Fk9d2Wzabd13nTMZzo+RVsy65uC8fFHNsu3gZE3wOCoFCQAAA7";
elseif($tag=="bm") $tmp.="LMAAJA+dE0/l3bDVEwgfBLyBCbSBPI2KhsNf5tRcOKrlJhxX+Zue+rOuN+SmfpRUv4CBCH5BAAAAAAALAAAAAAOAA4AAARHsIXjwAHt6Y2DQ0gybNuyJMbSNAvpvo/hzAqzGMmqaA7Tsx6EYjF6/HyHgwFxUDh4DAEDtnEkrlQNQirIagqEndcg9prP1AgAOw==";
elseif($tag=="bn") $tmp.="LMAAGViKsKJgctrS9GtU+BGJooTDV8LBNkeC+jSdA4HBPr24u7uBwAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARHcMlJq71KVWSzV4jQfYpAINoEDAhKHHDrJXQhBIOADMRMJwWDoRAgCDwAmrCQGA4BAc4CUTwUYMEfhfc6GH6Jy2SQDIvP6AgAOw==";
elseif($tag=="bo") $tmp.="KIAAO+xCdjKCKiSLIqKDPZoCP38BfkDBTaQCiH5BAAAAAAALAAAAAAOAA4AAAMiaLrc/jBKQ6q9t+gdxv4gIQBgKZLlF6Df4b5wLM90bd9wAgA7";
elseif($tag=="br") $tmp.="KIAAF5yfpWlUWusMKzUBA0wrfHuCAiGEgeQBCH5BAAAAAAALAAAAAAOAA4AAANLaKd86+pFMWBjRpTtejzDABBAsRioMhRESwSF0IFbAIxlrGxF4AoEnmzVc714ndXACKucMoURKQSZaWyBAcrS2Ai2j7BDJgZ/PKgEADs=";
elseif($tag=="bs") $tmp.="KIAABaKeQJhZ8DABAJ0elTWiP7+BAMDBALCzCH5BAAAAAAALAAAAAAOAA4AAAMsGLfcbMPJY+Bs1YC7siZgGHqGUJzoSZYpupptQcKxB4h4FnHVziucBTB4SAAAOw==";
elseif($tag=="bt") $tmp.="LMAAJllUJMsKv56BP6uBMJWVNbW1JxQSNEoJ25uZGNQTpyNcaoQDq2tXdbSFfoDBP39BCH5BAAAAAAALAAAAAAOAA4AAARH8MlJq72YtfaYuAxThItzKQqiGCW1vUmwKObEJAli4Gv9NAgEYIErOXxABOMQCPR8DMXw6Dgcjj+AgrCkegeLcNVLLpvP5QgAOw==";
elseif($tag=="bv") $tmp.="KIAAP6mqP6Af2RkszExm+Dg8P5bWwICgf4ICSH5BAAAAAAALAAAAAAOAA4AAAMueBojpTAe5qSkz76C99lESDRiSRhoqq5sW5JmWMxAE8z4DGFWxPeLRgb4Iwp7CQA7";
elseif($tag=="bw") $tmp.="KIAADLW5Hby/K62tFJSVBoaHBrm/Bbm/AAAACH5BAAAAAAALAAAAAAOAA4AAAMmaLrM9TDGRpe8MOjN+fhgGBJkaZ5oKqxs21ZwbExyU8xYAex83ycAOw==";
elseif($tag=="by") $tmp.="KIAAP+amv6amv6mpv7+/v8AAP4AAP///wAAACH5BAAAAAAALAAAAAAOAA4AAAMuaLq80zDKGYW9GJfNu9/EJ4ZFSH4koapcEACAC89uYDw37gwPzje8nuLHCFIYCQA7";
elseif($tag=="bz") $tmp.="KIAAOrn7J2prKu6ssfNym4qZIWLquURGTJClSH5BAAAAAAALAAAAAAOAA4AAAMwaLrM9DDGQ6u9toRQcBVDKHRYAYKmVwzAFgxkxhYFMHiHCAa4KWwxVRCHaxiPSEUCADs=";
elseif($tag=="ca") $tmp.="KIAAO66ufLKyMYcHPba29pxc+KDhf37+b4CBCH5BAAAAAAALAAAAAAOAA4AAAM7eFrWTioeZsZoUM5WaJaUgmnTAAhCMHxRQaDCxC4FOMsScRdDfAgrEqO22VUAgIuxcjEsLSMNxeGMJAAAOw==";
elseif($tag=="cc") $tmp.="KIAAPbg5NyvwtVcZ94JC2ZfuNGMok0ojgYGmyH5BAAAAAAALAAAAAAOAA4AAAM3WHRyVidKp8RbM5ISBIeaNIzkkEVCUAxqcxqBIWyGExlLUVvbgZ1AW3B4ABEPgNoxcPoRlcdJAgA7";
elseif($tag=="cd") $tmp.="LMAAKXqb7fuWX3foFnXz7DsYMLyTGravP7+BE3W3HPerEHS6jLO/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQzUK1JKw3I6iW3BZ03DeFkJJYQIklQJKFaEccRVFml1CWQTwlBAkUpiQg/kbICWi4GzkUEADs=";
elseif($tag=="cf") $tmp.="LMAAPLXDCkpoZq2IG4CbP3Z2ah8ZMJShGZjJP2OSJaW5GraBAYCuf4CBPv++f7+BAW7BCH5BAAAAAAALAAAAAAOAA4AAAREcIVFF2Oj0iBOvZm2CBMFikmaFpehpk0cExci3zLN2Pit87KHcHg5DI/HInKpPCqeT8GlAH06rldADcvFanfd7hfRjQAAOw==";
elseif($tag=="cg") $tmp.="KIAAP6YDPnQFP5nDLTTRObpJf39D/oWEnOvcyH5BAAAAAAALAAAAAAOAA4AAAM0eLpM9SyOV0Jc8xFzT34Gd1GFEF7OA4TiklZse7xB3H6FLeKmrbw9H2mlM9CKIYJyENQlAAA7";
elseif($tag=="ch") $tmp.="KIAAP5ORP5XT/7w8P5DOv7GxP7Bwf7+/P4MBCH5BAAAAAAALAAAAAAOAA4AAAM5eLrcPAAMx4oxhS6LteJZMxSkcAlkMR2AYV6nGygBbMPzMRD8K/CEVeVC8Bw4RQ/hEtIMAgGA0ZMAADs=";
elseif($tag=="ci") $tmp.="KIAAP7WXE7STP6+BP7+/AK+BAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMrKCowPoFIstiDk6724qyc40ngNWpKiH2bmZXd28Zs6tYWTc6ibOuoXG+SAAA7";
elseif($tag=="ck") $tmp.="LMAALhnkJJusPSnqPVrbvgJClFQvUQ1qqxTgicmsbuKsW9sxQgIpQAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARJUK1zlkkr65noScimJcIwCAm2FIpiLEQsE1axIAVCmihmhDedJwAISTSuSaWAAWZeosxRGn1uoNHpQrtBHHPVDEthC2cQWPMmAgA7";
elseif($tag=="cl") $tmp.="KIAANqetDgFZjo5nujE1t0fHQoKgv72/PUDBSH5BAAAAAAALAAAAAAOAA4AAAMuWKpj/k4JBmERYLYai6HcJ0zFxi0gF6wrMLzwSxx0bd84Pud8T+++oI1ALBqNCQA7";
elseif($tag=="cm") $tmp.="KIAAP4mBP6CBIp6PIJ2PP2RBP0MBP3eBFapVCH5BAAAAAAALAAAAAAOAA4AAAMyeHpTXsRIs9iDk6724qyc40ngNWoKB2DfVgQES7pBIKMWsJ5ll/Win8vXUghMQiNykgAAOw==";
elseif($tag=="cn") $tmp.="KIAAP73BP6RBP5NBP7WBP50BP4RBO8hE/4CBCH5BAAAAAAALAAAAAAOAA4AAAMxaLfcrKssAt8yIh5pTQiQQTSKAACjZh0DwDmHUgRUlF7wVsXwvTYZxy6HI5KMR+QiAQA7";
elseif($tag=="co") $tmp.="KIAANZuLO7uFORtIrKyTb1TRf5iBDMzy/7+BCH5BAAAAAAALAAAAAAOAA4AAAMnGLfcrC4eKBut62Jdh/8gaIxkaZ5oehJs67pCIc90bdsAIOy8LvgJADs=";
elseif($tag=="com") $tmp.="KIAAGNKrWMhe4yEzv+MjP9aWhgYpf/Wzv8QGCH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="cr") $tmp.="KIAANmNhNS5t/N2cnJ5xevg6v77+ewKBgIGkCH5BAAAAAAALAAAAAAOAA4AAAMteLrc/oHISWm5OGPBAeBgaIxBMJ7oWaas4bVpIMBGUBB3VWn8NfzAYPBBLDISADs=";
elseif($tag=="cs") $tmp.="KIAAODc9GpazKKY3Ma+7HwOcC0Qs/z8+/sNBiH5BAAAAAAALAAAAAAOAA4AAAMpKLbcXMNJUwKYrVT8tOKaFmGhdk1lcawsWxJtHMJxq9G1q+Y2H+O+QwIAOw==";
elseif($tag=="cu") $tmp.="KIAAIRAaPKanvdRVfa+xHqKvPUPEe/w9j1UnyH5BAAAAAAALAAAAAAOAA4AAAM0CLfcXMrJUsIwN2NMi/lgaHSCKBYCJRBs23oDFU1BQEmPkF7m1wU9kCooLOAcxmNjpjwkAAA7";
elseif($tag=="cv") $tmp.="KIAAJ+PYX5wdFlVrOFnBkFAuSIhovvx3AUFqyH5BAAAAAAALAAAAAAOAA4AAAMteLrc/uXJCQM9QIXYiP9f4YlGaZ7noK4si76m4MmEIN/1kmHQQliQgnBIHCYAADs=";
elseif($tag=="cx") $tmp.="LMAAAKiHhJ0UAJcYE5OrI6OWCM3tPP7BBoouGTYBJ7hCQe/BAMEugAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARAUMlJq60ILXBpWkvQJchXLIJEesZygEdiJFXrgisyZeCAJyuFTnEDEWYiCmi5IPgKHAlzCoouTtRlqpgFYbvMCAA7";
elseif($tag=="cy") $tmp.="KIAAL7bspXAhGikUf7aZuvmtPDtxvrEDf79+iH5BAAAAAAALAAAAAAOAA4AAAMzeLqsVAyuQoZcJuuxqv4GM4AfpxRk2BygtTLE6wRrEDOCQB9A/ga6ggBwWxWOAJlyKUsAADs=";
elseif($tag=="cz") $tmp.="KIAAODc9GpazKKY3Ma+7HwOcC0Qs/z8+/sNBiH5BAAAAAAALAAAAAAOAA4AAAMpKLbcXMNJUwKYrVT8tOKaFmGhdk1lcawsWxJtHMJxq9G1q+Y2H+O+QwIAOw==";
elseif($tag=="de") $tmp.="JEAAP7yBP4aDBIEBAAAACH5BAAAAAAALAAAAAAOAA4AAAIXlI+py+2Pgpy02ouz3hT4D4biSJYmUAAAOw==";
elseif($tag=="dj") $tmp.="KIAAIJl4f5wcP46PPqqqpO3kvT09DMFy2WbZyH5BAAAAAAALAAAAAAOAA4AAAMtSLbcXMBJU+Bs1V6aNx3dNQhBKBVkdqzsWgxg0c6ZPLcZceOFvrO9X8snXCUAADs=";
elseif($tag=="dk") $tmp.="KIAAPTU1PTT08gkJMYdHfLNzf///74AAL8AACH5BAAAAAAALAAAAAAOAA4AAAMtaKdToisq5uCUp72Dr7ZdVnGXN2JESgQFoL4v68KEuYXUXUYfGfY4ke53uiQAADs=";
elseif($tag=="dm") $tmp.="KIAADhTMD52EBkLBfH17ZFeP7CqPKgdCAyUDSH5BAAAAAAALAAAAAAOAA4AAANAeKpFMSuuBqCMjdirjDcBVowE4ZljmprCqQpwawByLASl6QFGjg/AgU4WtBQOgQ8BcDxKdA4Oo7ThNB7SaUWSAAA7";
elseif($tag=="do") $tmp.="KIAAP5ydHJy/Pr3+f7+/AIC/P4CBAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMsSLoi9XAxB59Urdqb9SVdFYxkA5zooK5s674oKgwkqRXNd+fXLugansT3SQAAOw==";
elseif($tag=="dz") $tmp.="KIAAO5ucJ0CBPq4uO+jomECBO4FBwQCBPj3+SH5BAAAAAAALAAAAAAOAA4AAAM3aLp2/octAZ0kpYDKcBgC9TBZU0WKZwwDlxaEARSi9cZzjSrw2kKkgsn1+oCAjEBmg5ScdoxnAgA7";
elseif($tag=="ec") $tmp.="KIAAEPNoVWVP2dVQq+jG3h0MgMDqqoDFPv7BCH5BAAAAAAALAAAAAAOAA4AAAMteLrc/jCqQeUZhIyISSASAQAgU5yn+KEsiglE2wqw0BoFruv5bvzAoHBILAYTADs=";
elseif($tag=="edu") $tmp.="KIAAGNKrWMhe4yEzv+MjP9aWhgYpf/Wzv8QGCH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="ee") $tmp.="KIAAKqqrCYOnAICBP7+/DIS3AAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMeSLrc/jBKEqq9V+jNu/9gKApAaZ7noK5s675wLA8JADs=";
elseif($tag=="eg") $tmp.="KIAAP7gd/70zv7qnkpJSdZaW/7++wICBL4CBCH5BAAAAAAALAAAAAAOAA4AAAMmeLrc/jDKQ6q9t2gd+v4fIIggCJxB+Qls+g1wLMtGbd94ru98byQAOw==";
elseif($tag=="eh") $tmp.="LMAAOCEhKouHFY+PNJCRO63t9tvb0q2TFZbTbsCBP37+gSWBQUCBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ7cMlJKapY3lzR5ponHGRpekiQrAWxvihSJMQMvEl8E/cMe4NXC5fzGI7IpMFzUDifUAWiGa0GqthsNQIAOw==";
elseif($tag=="en") $tmp.="KIAAKWlzoRKjP9jY2tjre/n7xAIjP+MhP8ACCH5BAAAAAAALAAAAAAOAA4AAANMSFA8Z4wJc1Q7Ik4S6nJQsF2E8hRjEQyAUD6GQQyDGN/YjR987/9AoC6WG9JKLkzJQBsUBgTB6kQwZJ7RwPNUqGayFwjDe9BermNDAgA7";
elseif($tag=="er") $tmp.="LMAAPchEPcpAPdaITFStQCMAPcxEJw5SmtSAP+9QgBr794hEACEAABz//cpEAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARAULVDlr1Ytqaw19vkWRqChFS2CWfYqGZTuBslIUAj0OGN7zQDo4QLBQaMpKYAEiaVruNz2pxaFVKr1ZDoer/eCAA7";
elseif($tag=="es") $tmp.="KIAAP5+BP6aBP4KBPIKBP4OBP72BAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMpOLrM9DBGQautBOjNeflgKI5kaZ5oOgZs67rEEM+yZEuDQFC5kP+6XQIAOw==";
elseif($tag=="et") $tmp.="LMAAJZCXDp+RGh4hKiYXFRtkhNEtBZMrnKiDPJaHPvFJuskHCyOBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ3cMlJq70463V6D4YReF1imiFRnKw5EAJBDO05GIJg0LVZwCsWYjgEFAoA4lDBbDqf0Kh0SlVEAAA7";
elseif($tag=="fi") $tmp.="KIAAHZi5Ip27Laq9Hpm5HZe5HJe5HJa5P7+/CH5BAAAAAAALAAAAAAOAA4AAAMxeCoV+nAZF6OY1eL8Lq1DSBhGaJokWRBsyxoFHKc0DBBroe86222cgyco+XCGRGQlAQA7";
elseif($tag=="fj") $tmp.="LMAAG5qtJK6qeKssP4yNIuS7EJCpMfNxwoKhFMzhuRFKduRl+FfUr4CBNF8hqhXf4J/9iH5BAAAAAAALAAAAAAOAA4AAARJUJXj3EHq6Y0aqI60bU2jJIvpEOPDvPC7OY0DCM2i4POSJI8GohJEaAKGRGCBoFgAjY1i4Gi1coOFtWVYGLajZAC8IVTJ6LQ6AgA7";
elseif($tag=="fk") $tmp.="LMAAIKqcF4GNMbGP+/v9nk3gktJ09XN8bYFDZSS2m9v6cBvialQecGsxc6Mnj0wvAICvCH5BAAAAAAALAAAAAAOAA4AAARYML21Hmkv66cQJYyzaUqjLI2pMUbxHHB8ZElSFE6qKEwjOQzEoIBoECgJhSjBKAAKBoKlUlA8EAaWYTDSYB2EBLf7EAcCLPLDIegBEOqrYC5SOxChuF4fAQA7";
elseif($tag=="fm") $tmp.="LMAALe3/CIi/LKy/Kys/AYG/JaW/BQU/KKi/Ckp/B0d/AIC/AAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQyUMlJq702GTzROQgnAQIXKkkgnZNxDImUDMc2JYcQK4FQVyFCasUBAEQKT2HH0SCfyAgAOw==";
elseif($tag=="fo") $tmp.="KIAAC4SnD4ipPLy/P5WVEoalDo6vN9KXP7+/CH5BAAAAAAALAAAAAAOAA4AAAMueHoxJCuu9qSk0C7ismadVYwF4JCooarD6r5GCxuoSaBkxFUfyH+Yns+j2REVCQA7";
elseif($tag=="fr") $tmp.="JEAAP7+/P4HCQcHtgAAACH5BAAAAAAALAAAAAAOAA4AAAIklA0JwXyomntqySeqDFhfGn2H13RhCSabqYpQi47nJMP0azUFADs=";
elseif($tag=="fx") $tmp.="JEAAP7+/P4HCQcHtgAAACH5BAAAAAAALAAAAAAOAA4AAAIklA0JwXyomntqySeqDFhfGn2H13RhCSabqYpQi47nJMP0azUFADs=";
elseif($tag=="ga") $tmp.="JEAAEpKfP7+BAICrBSdBCH5BAAAAAAALAAAAAAOAA4AAAIanI+py+2Pgpy02ouzDqD7/wniSJbmiaaqUAAAOw==";
elseif($tag=="gb") $tmp.="KIAAKSgzYJOjGxjrPhgZO/h6BAPif2Ih/4HCSH5BAAAAAAALAAAAAAOAA4AAANMSFAsZ4wNc1Q7I04S6nJQsF2E8hRjEQjAUD6GQQiCGN/YjR987/9AoC6WG9JKLkzJQBMUBITB6kQwZJ7RwPNUqGayFwjDe9BermNDAgA7";
elseif($tag=="gd") $tmp.="LMAAKrYBKaCBKJ+BEKyBK6uBNVaBDasBMTnBBaeBHOLBMsxBCN8BPXdBAWVBPr8BL8EBCH5BAAAAAAALAAAAAAOAA4AAARL8EklH7W1lnl3TUwojom0DE6qpsZiNsjqHEjjPkujHymt3wmArhEIDG0mwlAgON5yMEBK+HsZeCrf0yBTtSSgkbik4Ug8mYtCXYkAADs=";
elseif($tag=="ge") $tmp.="KIAAGICBJY2NIYODObm5KFBQv7+/AICBH4CBCH5BAAAAAAALAAAAAAOAA4AAAMgaKpw/m4xCKVp1I29Q3ZFGHqfGBLfQayrkL5wLM90TScAOw==";
elseif($tag=="gf") $tmp.="LMAAFjUBBmtBIJeBP4yBPpJBP6KBMJGBP6uBO0OBKXoBPz9BAO+BAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQxUMlJaapYrpvpWkA3fSB3YOR3DSgZCANCFF4aIHKVfrjBaTbBQvjbGUMKozKpbDpJEQA7";
elseif($tag=="gh") $tmp.="KIAADAwBGpqBAQEBLm5BP1VBPz8BP4CBBKgBCH5BAAAAAAALAAAAAAOAA4AAAMoaLrc/jBKQ6q9t+g9xv5fAAABCA6CYJ6i9w0HDMcHPdd4ru987/+HBAA7";
elseif($tag=="gi") $tmp.="LMAALozNK4aGeK1tv4uBOV1V/Lc3LZKTPeUT+fFx9mHh6UCBLIFBsEDBflPUf4CBP7+/CH5BAAAAAAALAAAAAAOAA4AAAQ+8MlJq71UCAASKlcQAIyhINeyMEywCFahzHSSquxiV0ieExZEY5ggTobIBuGQHDqe0MEBSq06ptaqNGsdWCMAOw==";
elseif($tag=="gl") $tmp.="JEAAOimp9VYWf38+r8FByH5BAAAAAAALAAAAAAOAA4AAAIllI95EaA7YnxAWhWsdEjLgADMSAJm9QjVRWlc4g1YPLwZjedeAQA7";
elseif($tag=="gm") $tmp.="KIAAMr2zP7OzALOBAIC/CIi/ALKBP4CBAAAACH5BAAAAAAALAAAAAAOAA4AAAMmaLrc/jBKE6q9l+jN+fhgKI5kZ25Aqq5r4b5wLMvC/Ao1ru+4WycAOw==";
elseif($tag=="gn") $tmp.="KIAAFK2BNJSBAKWBL4CBP7+BAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMrODpBTkBIsdiDk6724qyc40ngNWpKiH2bmZXd28Zs6tYWTc6ibOuoXG+SAAA7";
elseif($tag=="gov") $tmp.="KIAAGNKrWMhe4yEzv+MjP9aWhgYpf/Wzv8QGCH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="gp") $tmp.="LMAAP5ENP6mLP7aLP5QNP76LP68LP48NP6SnP52d3r0ZDLuDf4qPAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQuUMlJq70p672R/yC4LMBoniYQoOwgECt7CgUim0Y53Lx8/D9EcHjgGDWXpJISAQA7";
elseif($tag=="gq") $tmp.="LMAAMbFxxot4TCkTGQCnAJWjJ4CZAJ2ZL6ipL4iZN3e4/tGSE7RTfv79wMD/AK+BP4CBCH5BAAAAAAALAAAAAAOAA4AAAQ90MlJaahYNpJra0Y3fY2wnGhKNgnjvi2zBq+7CO5cM8DRrjFXAjCUfRCKpHL5KTye0OijMZBaH9WrdvuMAAA7";
elseif($tag=="gr") $tmp.="KIAANLW9LO05Ozt+X2B1GJmzEpOxP7+/CUttyH5BAAAAAAALAAAAAAOAA4AAAM2eCfa7kaRMem4ih1guu8AJwjF0wSBgRIT6xKZwn1efBR4rhfkvtNAz2s4NN0cpWDwwmw6jcYEADs=";
elseif($tag=="gs") $tmp.="LMAAG9v6T0wvMGsxZSS2ktJ03k3grYFDc6MnsBvialQeQICvAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQwEKiUVDkqa4UGLUKwaciBJIc5ZkbrGquSIohwSOtRUAAirgVLhYCIGY/IpHLJbK4iADs=";
elseif($tag=="gt") $tmp.="KIAAGi82BWh7xGm6/X9+lnB6wem+v39/AKr+yH5BAAAAAAALAAAAAAOAA4AAANHKCEC9oOwEI4tZDxD7PWZMUReeRAQVxxFe6EbsZYrLHary9oc+9Ub0ue16c0EPl7HZIFpljmQ6OZqWW2RGUtQCAA0I4BCkQAAOw==";
elseif($tag=="gu") $tmp.="LMAAFVLpNGPtOroFIaG3Hpy+KGbiVWdaNBWfLmz4NFuc54wdVcErMTE9sECP5YEbQUD+SH5BAAAAAAALAAAAAAOAA4AAARSsDVHJ3V2vr2X4hsFLgVygGIXGAbjcOnjMCyTwO92FCWDLKHc45A4EAO5WIDhYyaFigFiQCAAZcIcAPAJcha3gqCLHQEENxzooSCHJJiJXEKPAAA7";
elseif($tag=="gw") $tmp.="LMAAKQCBK4CBE4CBGYCBHoCBDICBN16BGJKBPb6BL4CBP7+BAKWBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ0MMlklL13Usx15dn0gYpHWkkgjWAgEBQiz3NSDMmx7DyfAIBcb6jRDX0T43FRXO6aTugyAgA7";
elseif($tag=="gy") $tmp.="LMAANzcBLq6BI6OfFaKVHJqDFpKBDKqNEu1TEwoBHTGcrnjr2kGBPT6nf39E7oCBAOXBSH5BAAAAAAALAAAAAAOAA4AAARCcJhHq6VLqHOvWwTDJB3lnEXTMMpknScCqCxnwo6sruODn4vAjvb7CHeiH+JII+F0q00Floq6piARqZSRliiSryUCADs=";
elseif($tag=="hk") $tmp.="KIAAP6vr/56ev719/4wLv6Sk/5WVv7Oz/4DBCH5BAAAAAAALAAAAAAOAA4AAAMqeLrc/q4EyASgZxxj5CsCRxgC4QxhUHDFMxDwRXFAB4GdMLmE1mPAoDABADs=";
elseif($tag=="hm") $tmp.="KIAAPbg5NyvwtVcZ94JC2ZfuNGMok0ojgYGmyH5BAAAAAAALAAAAAAOAA4AAAM3WHRyVidKp8RbM5ISBIeaNIzkkEVCUAxqcxqBIWyGExlLUVvbgZ1AW3B4ABEPgNoxcPoRlcdJAgA7";
elseif($tag=="hn") $tmp.="LMAAL6+6Y2N3JaW3Hp61NbW9MrK7KGh4bKy5Fpay0pKxP7+/AICrAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQrcMlJq70464W6/58iKoYgBseoKkd7GMA6FoAAE/IZiIOhJsCgULgpGo+WCAA7";
elseif($tag=="hr") $tmp.="KIAAM4+VM1Sb+d0fO+NjywoqPz5+eADCQcDuCH5BAAAAAAALAAAAAAOAA4AAAMtaLrc/u8QqCaZbAg9QgABtxVkOZxlmoaD6p6tmwJoetz4SeB87//AYO9CLBoTADs=";
elseif($tag=="ht") $tmp.="IAAAL4CBAMCqyH5BAAAAAAALAAAAAAOAA4AAAIRjI+py+0P4wK02ouz3rz7nxUAOw==";
elseif($tag=="hu") $tmp.="JEAABufJP7+/P4fFwAAACH5BAAAAAAALAAAAAAOAA4AAAIalI+py+2Pgpy02ouzliD074XASJbmiabqOhYAOw==";
elseif($tag=="id") $tmp.="KIAANra3O5CRO4WFO7u7Obm5P42NP7+/P4CBCH5BAAAAAAALAAAAAAOAA4AAAMlKLfcrC4eKBut62JdQ/lgCA5GaZ4mia6Gyp7uW8Yy/QJEru96AgA7";
elseif($tag=="ie") $tmp.="KIAAFa2XP7CXAKWDAKSDP6eBP7+/AAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMzKCpQXoFIMupoL07LHpzEcnmaxGFOSQ3CmIEti34b66Yw271bPKuWG82kEAJtP1AwOUkAADs=";
elseif($tag=="il") $tmp.="KIAALi4/IqK/KKi/HV1/Ftb/Nzc/AQE/Pv7/CH5BAAAAAAALAAAAAAOAA4AAAMxWFfK28rISau9J2unex+D1xUEAZZiFoQHAaQHmBECXJYDAWdDIDLAAiAIvBiPlJ0nAQA7";
elseif($tag=="in") $tmp.="KIAAMK0uI2Svl9lntDS5C+yLQqhC/r38/uSFSH5BAAAAAAALAAAAAAOAA4AAAMoeLrc/jDKM4y1ANy9RxAV1wmg2H2haQWBSLxwHBd0bd94ruME3fu4BAA7";
elseif($tag=="int") $tmp.="LMAAPf9/NT0/K7r/Jbk/EfQ/BjF/GfZ/Hfc/Ibh/FjV/DLM/AO+/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARfcMlZyryrFpWMUhZ1cByRjEd4JISZdIJiINLgKciBDAk3LDLCLHAQABCsUSFmEOwCgZugYjAMAIaigCAzWHQEHgJAxB0kOJaCcDCwEYpJIrf+6BKYxAA542EoaH+CfxEAOw==";
elseif($tag=="io") $tmp.="LMAAOZ6hAI2BNK2JNpidKJqbyIYb+6nr46KxP4OEPHx+EJCnFVUoNHO5nN1rDIylLKsxCH5BAAAAAAALAAAAAAOAA4AAAR48BWFXBkvpfwYMQ2yDIeyNFbgAICBtIPxNEkTLEiuI0UjFYHCx8UwEGaKmuPxGOAWxiXDQSCMHE+HTFFgCh6Hw4bGaDASi4egcVIoGgrHwSGnp5mMQ+fAyDOYJgtYcSgmDm59fHgdeGZ0cyaRcA4oGmYJemMJZQkRADs=";
elseif($tag=="ip") $tmp.="IAAAAAAAP///yH5BAAAAAAALAAAAAAOAA4AAAIYjI+JwLoHXIhPUSjvlWZnXoHeB5bJaB4FADs=";
elseif($tag=="iq") $tmp.="KIAAGnOacHqv53fnvVmZTIyNPf79gkJC+0DBSH5BAAAAAAALAAAAAAOAA4AAAMqeLrc/jDKM6q9t+jNewFBIQhgQHKAKJKmoIWeR8x0XRt4ru987/OEny4BADs=";
elseif($tag=="ir") $tmp.="KIAACSHMv6gn/5dXWWpcf4GCO8sK/76+A96HSH5BAAAAAAALAAAAAAOAA4AAAMueLrc/tABcGajc+jNuflgEIAkKYhjSQanqralIMuFUN90oe/8TvzAoHBI7Bl3CQA7";
elseif($tag=="is") $tmp.="KIAAE9PpL6+2/xmZO+PlPPc4x8fhP0QEAQEfyH5BAAAAAAALAAAAAAOAA4AAAMtWLcjsHAp5qKl787T8oXdR4xEQ56Eoa5s675BHJhyvYUaWOXYF+GWgrDQGRoTADs=";
elseif($tag=="it") $tmp.="JEAAP////0MAAGCCAAAACH5BAAAAAAALAAAAAAOAA4AAAIklA0JwXyomntqySeqDFhfGn2H13RhCSabqYpQi47nJMP0azUFADs=";
elseif($tag=="jm") $tmp.="KIAAK6uBJCQBE9PBGTABLrXBPD3BAcHBAeYBCH5BAAAAAAALAAAAAAOAA4AAAM7SLfcO6U4R4qIY54ajKlZE3XeV4RHJJQlUBBQwc5BRMyzG+HtG68zEENVupwcI4MR1ai4FJpFRRJlDBIAOw==";
elseif($tag=="jo") $tmp.="KIAANxOUIsOBOyjolpYQ/3598wFBgUCBA2dDiH5BAAAAAAALAAAAAAOAA4AAAMxaLrM0VCV8uKa00pMh/8ehwlEaU6CwAFmiaoY24po63LDoe86FuQ83gQY5AWKyGQxAQA7";
elseif($tag=="jp") $tmp.="KIAAP4YGP57ef7h4P7W2P6gn/6PkP4CBP7+/CH5BAAAAAAALAAAAAAOAA4AAAMqeLrc/k0QIuApJpvysM6EA3wZ0AykVi1oagyNazbexznBF1hDQVnA4CIBADs=";
elseif($tag=="ke") $tmp.="KIAAN1/hMykpEFLLsZQUvTR08EUIBcOEBuENCH5BAAAAAAALAAAAAAOAA4AAAMwaLrc/k0oyagCY4RGeg9Z4HVFaWZmmholq67F4L7n8I4ECAD44f+Zn3AoGBqPyGQCADs=";
elseif($tag=="kg") $tmp.="KIAAP5uBP6WBP5aBP7zBP4vBP6xBP7QBP4DBCH5BAAAAAAALAAAAAAOAA4AAAMzeLrc/o0AQeARZZhSHcmGMQSPMBRBEHZMoAWFyC5mYa+OENrnvGQDjQDyCQF8EaRlaUkAADs=";
elseif($tag=="kh") $tmp.="KIAAPooMPx/gvo/Qf6vsnoMVbEHLfQEBggbpCH5BAAAAAAALAAAAAAOAA4AAAMmeLrc/tCVSWs1OOutBfCcFgjBGGJDaoZCOgTAGbipRtx4nkd87ycAOw==";
elseif($tag=="ki") $tmp.="LMAAMSoBMpCBLCQBPmEf94bCmtr2rCty7BdBEhI0dTU9O/vC42N4sUtBu3s8iEhyPwDBCH5BAAAAAAALAAAAAAOAA4AAARX8ElGJztM6sfC+QyxbYwgYONYpSTISoSgKEDwHvMssAyQ0zZJY0AYNBqzI9HoWDQWDoQhgWg+HVcnFZHINpoJqNRQLSQK2AVCWzA3yIavGe0wGBwOczUCADs=";
elseif($tag=="km") $tmp.="JEAAJ/sn+v762LgYQjNCiH5BAAAAAAALAAAAAAOAA4AAAInnI+ZASeSBBvvqRAMVHTyA2TatojUh31IuAEkIr2oKMOTFVVejnMFADs=";
elseif($tag=="kn") $tmp.="LMAAJgyBNLS1FKpBBiKBKJKBJzOBFBQEoxvGrywNoiIRNXTBC8vEe7xBAJ+BH8DBAUFBSH5BAAAAAAALAAAAAAOAA4AAARSsMk5CzPv0TmUWpm2CUwRZiOTnGh1PcmaLVLHgE8QZAbTDKXTApRgHEgyFoIBcBhhh9DC03SAFgEEj4FweB0hA+hg/HqVDIL5PEMoqusZd22OAAA7";
elseif($tag=="kp") $tmp.="LMAAMQTEeutrMooKM46OPPV1/339eKLi9ZfYdt0dW5u0L4CBAICrAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ8cMlJq70p670P8kjojZ9iBkFxmGxrqEQBtK6gAMdKm0SgCKqdyYAwDAgzoeJFGAhDIQMRSuVYNZeslhIBADs=";
elseif($tag=="kr") $tmp.="KIAAPdZWaaUncW1ufMHDTcjj9bP03Bnbvr5+CH5BAAAAAAALAAAAAAOAA4AAAM9eLrc/qeY8oJRJqsilMjCNx3AYAKHFURdaZodxbxEjTp0vTKdUf+UWIbi06UMK+SFtUEKOw4LBEKRRRayBAA7";
elseif($tag=="kw") $tmp.="KIAAAlOCY4cHMbFxGa+bA4LC/78+gSTCPkOCyH5BAAAAAAALAAAAAAOAA4AAAMqCLbcTMpJQuSEttE6uv+bUIxkGZZocabkyqrUIc/0QQV1Huc1wee4Hy0BADs=";
elseif($tag=="ky") $tmp.="LMAAI07eWrVl8uwpG+Nj3q2lLaVOnNw1r4CBL9NXNXQw0AzvtF5h8iSp2hTq/T28wMDvCH5BAAAAAAALAAAAAAOAA4AAARWkL2Gnlrq6Y0YVd4mLiSyMMtmMMZzvPChGU5TMyiSLEbmOANHgoGgNBgAi6NQYNQegORl4hAIEg6RyBYIYLUbxTIQBG8SBUJBYNY0EthM+2FItOb4eQQAOw==";
elseif($tag=="kz") $tmp.="LMAANzcIMLCPGhol/39BKysUkZGuVpao42Ncnt7hSoq1BkZ5wIC/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARNEKlFq6Uk3TUt0paBSJUAUskxBEZ1dFQBDMNRGXAhzEM2ZRVCIUATfBZAykFEOBSAuErBaSgYbIvDaSHQGaoUkkVBOCphmyA6vRCzKREAOw==";
elseif($tag=="la") $tmp.="KIAAGRivFRQtJmV0fv7+1oylJ4eVD46rP4CBCH5BAAAAAAALAAAAAAOAA4AAAMoeLrc/tCRSWs1OAMBstdDGHyeEA4CmZlhqhrB+WaBMHpFru975P/ABAA7";
elseif($tag=="lb") $tmp.="LMAALruvND00MaGXN2LdHLadJXklCPIJQnBC0jRR/6WlP3++/4CBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQycMlJq73Yps0H/0oYFgchniJgIEeBigFizAbwKgV7HIj55jqC7wZ8fQaegeCTyDif0AgAOw==";
elseif($tag=="lc") $tmp.="LMAACIiHMrKWLy8PFZW/EtLOIWFaykp9fv7BHp6XpKS0AcHBwIC/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ4cMlJqzXWjpRr4p1kIMQQLgmggF2iKAiWDcS7tvZ9IQrBl5ZU4XAQAFiTQIDIFMhEhSiiMI2dLBEAOw==";
elseif($tag=="li") $tmp.="KIAAHR0MIyMIFFRTMLCBKioDOXlBAgEevwCBSH5BAAAAAAALAAAAAAOAA4AAAMfaLrcJq6FMgqJCtAS8Csg4GVjyRxoqq5s675wLM9tAgA7";
elseif($tag=="lk") $tmp.="LMAAHtvBMa6BPX5BGrCBAKWBP5qBNjQBP6aBLWmBOXgBJiCBIZsBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARSUKQpzLx3EFAOWmCoBJrSKaGIlB04Igi6EubhGkG8zJytKIYPaFZboCyBxI7lMwiegiWtA1gkoEpi62dQIALSIggMC59SIdLUgwY5LxKDXH6JAAA7";
elseif($tag=="lr") $tmp.="KIAAG5S3/39+0Ef2POwuPGRmPnZ3v5ua/cRDiH5BAAAAAAALAAAAAAOAA4AAAM9KCrX/gqIQqsFFJjNuxiDsBGjQRoCQQgB1Vbtwjz0UNjgreNq7/+dYLAQaBmJyCJt6SCAnAOoEyqsbpjLBAA7";
elseif($tag=="ls") $tmp.="LMAAFJS/Hh4/JiY/AKSPAJVjL+/SBwt5u3t0NXVcQK9BQME+/39+AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARFcMlJq73nIHRlWFu3AApSFFx1GEq5pVPRtmBRCbNiaMUxkTNCQuJbrHLCRFHDmg0S0Aku94QOF4GcwWo9AFtJbqIJFlsjADs=";
elseif($tag=="lt") $tmp.="JEAAAK+BOwPBOn5BAAAACH5BAAAAAAALAAAAAAOAA4AAAIXlI+py+2PgJy02ouzBqH7D4biSJbmVwAAOw==";
elseif($tag=="lu") $tmp.="KIAAP9qaoGB/////zw8//8AAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMeSLrc/jBKAqq9V+jNu/9gKApBaZ7noK5s675wLA8JADs=";
elseif($tag=="lv") $tmp.="KIAAKI6JKJGNPLy9Ml6ZenFvKIyFP7+/KYiBCH5BAAAAAAALAAAAAAOAA4AAAMnWLfcrC4eKButa+jNuTBgGH4gKZ4lqhJs67oXFlezVEdBoe98AQAJADs=";
elseif($tag=="ly") $tmp.="IAAAAK+BAAAACH5BAAAAAAALAAAAAAOAA4AAAIMhI+py+0Po5y02qsKADs=";
elseif($tag=="ma") $tmp.="KIAANobBMIsBKs+BJBSBFh9BH1hBGhxBP4CBCH5BAAAAAAALAAAAAAOAA4AAAMkeLrc/g7ANsJcpUxRBiGc5XiAYAhTYRjDRRjvBGiHcd14rh8JADs=";
elseif($tag=="mc") $tmp.="IAAAP79+/4CBCH5BAAAAAAALAAAAAAOAA4AAAIRjI+py+0P4wK02ouz3rz7nxUAOw==";
elseif($tag=="md") $tmp.="LMAALQ2BOLVBK9zBJ6KBHlvI8uyBMSVBcxPBFNTavz7BL4CBAICrAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARCcMmFkk1HaTVpCla2dVUBihppBIGBchMyCMLwqgDgbrCEGDQDgEciEH63mFGW9A2MhSZlUCjsRrFEFUPMXqSVLy8CADs=";
elseif($tag=="mg") $tmp.="KIAAN4AANbW1v8AAP///wBzAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMkGLMj/k8xSOWi0DbsNO/MxmlAaZoaoa5ryrLuq8Yy/dpwKK8JADs=";
elseif($tag=="mil") $tmp.="KIAAGJPrGMgfImCyP6Mjf5ZWxsbpP7Rz/4XGSH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="mk") $tmp.="LMAAP5lBLNvSv5zBP5KBP4xBP5YBP6FBP47BP4kBP6aBP4RBP4EBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARacMm5FL3rLEQyRopSIEdhIZegGMdgKAJFoEmRJEBSadJhGInDISFIDCQKwqBgGAQCrsPsxKk9bYMDSMLEDnCGwoRgIf5ylc4kxvLBLiARgWDaYDoIFA+D5EcAADs=";
elseif($tag=="mn") $tmp.="LMAAOLaAO8lAO8nAO8oAOiNAOtjANT/APAiAOLOAO4/AO45APAqAOazAN3/AEq17+8pACH5BAAAAAAALAAAAAAOAA4AAAQ48Enpap3zUOuwRMLDdV6yWd4DnBdWEIEweg3TBDPWFI3I0YZebtJQCH86whGFASxWQ8ngMY16ohEAOw==";
elseif($tag=="mo") $tmp.="LMAABNvACR3Aery6LbTr5K9h1ycSzmHIh10CB91CB50CBdzAB90CCZ3DyZ5Dxh0ABhzACH5BAAAAAAALAAAAAAOAA4AAARbkK2Tzkpp1tSY+2D4dc5jPgqgnA9pKk4gl6aLBkYROGvr3QCCAMCr/RSIwkBAMACMJUBDQBUUnr4SkjDgOqEmQIFARvRsqUIBgc2yACqWjUWrNRYIxAK/x+sbEQA7";
elseif($tag=="mq") $tmp.="JEAAP7+/P4HCQcHtgAAACH5BAAAAAAALAAAAAAOAA4AAAIklA0JwXyomntqySeqDFhfGn2H13RhCSabqYpQi47nJMP0azUFADs=";
elseif($tag=="mr") $tmp.="KIAADa+BEy+BHi+BCO+BLa+BAO+BAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMmWLrc/i4IyAShKwQ68JpN0DEEwAxXYwna6qBEHI8NIBP0M+Re/yQAOw==";
elseif($tag=="ms") $tmp.="LMAAAePE/fNgjZ+SgICglJso+OXoFSFzIRyaQAvZQBKmzdjt6aelulFTgQAGwBXsgNm0CH5BAAAAAAALAAAAAAOAA4AAARWkCnH3iEu66SWYcbyjOTjKETBFMaTvK/zMHStNDiOjIZaKA/cANHYLRaKCjInKD4II+CI6ZSVgjhA9Wo5NAAXE3cROAA8Ge6DfDRZxyK3+upIaO74RAQAOw==";
elseif($tag=="mt") $tmp.="KIAAPnr7OHKyZqMjPDg4MawsLKepP79/L4CBCH5BAAAAAAALAAAAAAOAA4AAAMoaGDM9/AYEpqJMAixHD5DQXTXZwSD9UmWh7VuBJcvvM63bep1m/ufBAA7";
elseif($tag=="mu") $tmp.="KIAAHoChHLmBALOBP7+BAUF+f4CBAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMgWLrc/tCBSWslOOvNu+dDKI5kaZ5loK4sK7xwLM90PScAOw==";
elseif($tag=="mv") $tmp.="JEAAO7u7v///zOZAMwzACH5BAAAAAAALAAAAAAOAA4AAAIgnI+pa+IPEZxCwhAPBNM6nDUP+HgC6ZhnOFCsWzLybBQAOw==";
elseif($tag=="mx") $tmp.="KIAAI6ilLvDuEVUP0yqTvhZW/T19AKOBPcCBCH5BAAAAAAALAAAAAAOAA4AAAM0aGpTXuTIs9iDk6724qyc40lgEQTYtxWCkJJb0AajpgyyW5cA8NqWTqYkVN0uu1URdlweEgA7";
elseif($tag=="my") $tmp.="LMAAGBMqGAgeIiAyAAA+BgYoPj8APiMiPhYWPgUGPjQyAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARHkJBSSBgoazQrAUMijgklTdiWmV1IiiZFHchB2ywVGkbCGx1JYWArGg4CASU5+Dmf0AOvSK3afKJeD4ul1b4ZL+1FHqnOmggAOw==";
elseif($tag=="na") $tmp.="LMAAPj4BNjYFBSJEmGvYE5OlLWtmbZxcKLCmCgohJ1TT5MpKLSQi3V0jH8EBQQEfAJ+BCH5BAAAAAAALAAAAAAOAA4AAARP0MlJHSqtVrJaJgxSMYanOAHAUExiHki6SovbJMfjEIXoFAqPYfDQTS7BxoJYPHY8y2Jz92wUBNIm6YXNPrYNxUHQzdpw3qwHnZY2hu1sBAA7";
elseif($tag=="nato") $tmp.="IAAAP///wAAgCH5BAAAAAAALAAAAAAOAA4AAAIUjI+pu8APjXtuMoCjjFUH64XiGBQAOw==";
elseif($tag=="nc") $tmp.="JEAAP7+/P4HCQcHtgAAACH5BAAAAAAALAAAAAAOAA4AAAIklA0JwXyomntqySeqDFhfGn2H13RhCSabqYpQi47nJMP0azUFADs=";
elseif($tag=="ne") $tmp.="LMAAP6WLP62bP7y5P7u3P6SJP66dP6aOFq6XP6yZP7+/AKWBP6BBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQtcMlJq70464W6/16QjONAAAKpkogkrmq7FLA6AEaqHnzv+4qgcEgsGo/IpCICADs=";
elseif($tag=="net") $tmp.="KIAAGNKrWMhe4yEzv+MjP9aWhgYpf/Wzv8QGCH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="ng") $tmp.="KIAAGqubOLi5CCSJmK+ZD+tRRKSHP7+/AKTBSH5BAAAAAAALAAAAAAOAA4AAAMxWLdkbmMtxR6Uh572otSc401SeH2lNWZph4Hq24py5aI2jW/xbq6CoIAQKAYAgkIwAQA7";
elseif($tag=="ni") $tmp.="LMAAOru1GqahGKShPLy5LaexLqizOLm1P7+5UpK+1pa+/7+/AIC/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQocMlJq70465W6/58iiscAHGNKHkSBqqkhBACcHvg7Inzv+5ugcGiJAAA7";
elseif($tag=="nl") $tmp.="KIAAH5q5P5ORP4OBP4KBP7+/DIS3AAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMhKLrM8zDKSZtdIeu9if9gKI5kaRJAqq5r4b5wLM90bRcJADs=";
elseif($tag=="no") $tmp.="KIAAP6mqP6Af2RkszExm+Dg8P5bWwICgf4ICSH5BAAAAAAALAAAAAAOAA4AAAMueBojpTAe5qSkz76C99lESDRiSRhoqq5sW5JmWMxAE8z4DGFWxPeLRgb4Iwp7CQA7";
elseif($tag=="np") $tmp.="LMAAGRgxNJTVN12d52MycSv0T4yr7wuPDIHhdXN51cDXrMEEP39/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARPsJBFq6UnnXHvUUqSAEi3JIohGMZYWkdQIgGYSBXKtqh4bIuPTYIoGhEoEKhgEioVhVcuRUAIltKgQkBBKA/SZEBQ+060z3SCkxG5379BBAA7";
elseif($tag=="nu") $tmp.="LMAAHpsp01Jj3E7eaaIlI5iNKysLAICfIZahObNL74CBDUpeOWxgteOjsx0V6hyev7+BCH5BAAAAAAALAAAAAAOAA4AAAQ+kAXjnFENvb0FA03jAQW3OQxzHM3iaGbSJAQhJ4v5OAtT9S/doKFgDAAMQcnUCGAcisACpqtar9isdsvtViMAOw==";
elseif($tag=="nz") $tmp.="KIAANCmwr5Xhn1ztlAqkN96mGRImckvXgYKlCH5BAAAAAAALAAAAAAOAA4AAAM1GHBlTCdKBkIpcEYhCAmEUEzDYZzoKQ2jAAAewGnPcAoBPRClfeCR0aFEKxqPyKSSpCQuDwkAOw==";
elseif($tag=="om") $tmp.="KIAANZdX1xNBMgmJjJuBOeeoAKWBP7+/L4CBCH5BAAAAAAALAAAAAAOAA4AAAMtKKdk/k8ABqsg57Qap+bRcgBEaZpZqq5s674wGwx0XatBoe87zv++Xy+VE+oSADs=";
elseif($tag=="org") $tmp.="KIAAGNKrWMhe4yEzv+MjP9aWhgYpf/Wzv8QGCH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="pa") $tmp.="LMAAGZm/MfH/P5gYNLS/P5qbP7a3BIS/P7IyPfu9AMD/P4DBP39+wAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARDcMm5lL1qjonvBFyXLUACVqIUGIEkjgPSoh0Vdkai5waCLL+fbqibFCbE4YSATCYkAoVA4nwuDooD1Sk5ILSLqk0SAQA7";
elseif($tag=="pe") $tmp.="KIAAGNOKYpuRH+ff5+/lMTbt7lqaPX28pkDBCH5BAAAAAAALAAAAAAOAA4AAAMxeHplbmVJ9uBc7cVLNaeEs10FIQzEOBWnqUrFAADCixFAkH4NanEZEa9iUwR/JKIkAQA7";
elseif($tag=="pf") $tmp.="LMAAIo+rMy6zNhulObi1O66VIKC/O4uJN5KVKio/Ht5+mxd8v7+ZfuUjv7++f4CBAAAACH5BAAAAAAALAAAAAAOAA4AAAQ00MlJq73Yss17byC4HMMSnuJiECYaLkwQMC06IICiAIgLJjpgz9coJBLDkIchECwz0Kg0AgA7";
elseif($tag=="ph") $tmp.="LMAAP6uqP5ZWfLm8Gho/JiY+MTE/Do6/P7+Ov7+n/7+8P4DBQQD+wAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ3cKxJK0XE6oVS2VUiCga4iKi0JchxiJnGuh3yWfPLCkrv5yKAb4gSBYbE0RHp6wiZxCfUt5z6IgA7";
elseif($tag=="pk") $tmp.="LMAAGGvXyeTJ1KoUILChHW6dMjkyDabNrDYrxWLFt7u3P7+/AJ/BAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ+UMm0qr1S0cvzXgbSTZUBVIG4eNVhFUHFIm4FxCtp1KMG8hgSQsGRkRYFQkWV8y0EigFAaXQ+D4Ogtdj8cCMAOw==";
elseif($tag=="pl") $tmp.="KIAAPwMAP75+f0MAP0LAPwLAP7+/v///wAAACH5BAAAAAAALAAAAAAOAA4AAAMwaLrM9TDKZ2AtF7fNe54YFIxkWQpoqqpE2w7vAM9ynQ4CPgB87/u1oFDmKhqPSFcCADs=";
elseif($tag=="pt") $tmp.="KIAANHPtNy0pNWJXNBLLo9QMOAnF1R6UvkDBCH5BAAAAAAALAAAAAAOAA4AAAM0aKp0/m4xCKVpNNpSsnyDpwgDQHbVIgABEaZKwXKUNASCgD7WUWCw0WDHkwBrxoxmcYQkAAA7";
elseif($tag=="py") $tmp.="LMAAJaxuISqeP4qLHbKRFoq1MmWxOvG3FpZ+/5YWv79+wIC/P4CBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQvcMlJq70464W6F16YjGMBFGRKGsAAGGpqBDQck4WBqkfvE76gYkgsGo/IpHKpiAAAOw==";
elseif($tag=="qa") $tmp.="KIAANN6f+rExOawtNSSkePc3KIsL/n596oFByH5BAAAAAAALAAAAAAOAA4AAAMrSDrV/iaOQ6uNhth9MOBXFIBUgQkk5aWdyJ5Fik1y9JFmpNUGTSoExmOYAAA7";
elseif($tag=="ro") $tmp.="KIAAGZqfP5qBP4OBP4KBB4mtP7+BAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMySEpQXkFIsdiDI4/aXhgTd0Wa6Gnb0jlfRqkjmJms9iorJoA0tO+9liQomcFOoWNNkwAAOw==";
elseif($tag=="ru") $tmp.="KIAAO8YEDkh1uchGHtr794IKf8AADEI3v///yH5BAAAAAAALAAAAAAOAA4AAAMneLrc/jDKM6q9N5jNO9deaIBiR5Yboa4sCxRwLMfvbBf1LQt87/sJADs=";
elseif($tag=="rw") $tmp.="KIAABoaBIyMBLKyBGRkBP5CBPn5BP4CBBXEBCH5BAAAAAAALAAAAAAOAA4AAAM4aGpUXifGxR6Uh7YnsBZBcEnaEA5YthCDg3prWwwdGQPAOMVFUNsKliOQ+jgEP1XQUlxZkhomJgEAOw==";
elseif($tag=="sa") $tmp.="KIAABuOHKDPn16vXkSiQ4nFina6dTabNgKABCH5BAAAAAAALAAAAAAOAA4AAAMoeLrc/jAKYgYpJTQQisDEoDVGIHyC5VwXUBlRLDeDYYsAZNvU7P+OBAA7";
elseif($tag=="sb") $tmp.="LMAAJeXUcjILNzcGOLi/L6+9La2PHV1ql7eBI+P56juBE9PwTk5yCYmzuj3BQQEzAXLBCH5BAAAAAAALAAAAAAOAA4AAARF0MlJKVtS1WkMkgOzAc3CIItWBc3jnCa1CMnzeC8hOkpT2wrVx0E62GybQsN4dE0YtOZxsvBJpw7D8jotco+sb/MntkUAADs=";
elseif($tag=="se") $tmp.="KIAAPLoDO7iFNrOJObeFJqGbH5mhP72BDIS3CH5BAAAAAAALAAAAAAOAA4AAAMneHoy+7DByRx98q48iy8D8I2FYZ5oqq5ESwSAKxOYpVW3wmn71S8JADs=";
elseif($tag=="sg") $tmp.="KIAAOdlXO6KgOI8LvfLx+VRR/rm5N0rGf7+/CH5BAAAAAAALAAAAAAOAA4AAAMkaLrcEKLJQapkVJC7hgac8kShQoZFqhYDux5wLM90bd94rtMJADs=";
elseif($tag=="si") $tmp.="LMAAE813hwc7PDa6KyO4Lq6/MrK/GZK3HNv+cYCPP7+/AMC/P4CBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQvMMlJq70ihHOnUIHRScdRAGWqHspAAEoszwow0Hiu7zPi/0DgYkgsGo/IpHK5iAAAOw==";
elseif($tag=="sk") $tmp.="KIAAPZoZParq4yUu44SNLtDWAsqe/b29vQICiH5BAAAAAAALAAAAAAOAA4AAAMxaLrc/irIANU55EAhDgAHJ4pFQUhEqa4FlrHshcFratLFMNiE7vsyQkZGLBqPyCQyAQA7";
elseif($tag=="sl") $tmp.="LMAALv19Hvz+j3BeVh/5nj38QmWEhacG2m97lI23wCRBW3r3uf15/v8/DAO2X7//4H//yH5BAAAAAAALAAAAAAOAA4AAARH0LlHq33Sqc07oYRRjOSYCGCRrCyLPqEhz3KBTkuu74D0MMCgsIcTGnuPAGLJbA4ogYZ0Sn0mqdjGc3Loer8KzORyyZjPmQgAOw==";
elseif($tag=="sm") $tmp.="IAAAP///wBmzCH5BAAAAAAALAAAAAAOAA4AAAIRhI+py+0P4wq02ouz3rz7nxUAOw==";
elseif($tag=="sn") $tmp.="JEAAJnMAMwzAP/MADOZACH5BAAAAAAALAAAAAAOAA4AAAIonC2ZwXGoRHMvyvaGnXnjGnEVMAAX0wnaSR0eCiqiG360bEM4fC9NAQA7";
elseif($tag=="su") $tmp.="KIAAPvxBPXTBOKKBOyyBMkoBNRYBM87BL4DBCH5BAAAAAAALAAAAAAOAA4AAAMieLrc/ssUAxeZ1ZasShGZABwBUV1DQEEpMEKYYZhcbd9cAgA7";
elseif($tag=="sv") $tmp.="IAAAP///wAA/yH5BAAAAAAALAAAAAAOAA4AAAIRjI+py+2PgJy02ouzBrD7DxYAOw==";
elseif($tag=="sy") $tmp.="KIAAKLQoF6vX+Xx5f5KTEpKTP3++wICBP4CBCH5BAAAAAAALAAAAAAOAA4AAAMneLrc/jDKM6q9t2ihO+9bAHyCCGpB4Jnn57lELM+zYd94ru987xsJADs=";
elseif($tag=="sz") $tmp.="LMAACktNPT09KBgMN/R0K1IGlgNCmRodk9PUKIrGRIQEMa5uJsGB8pmBv7OBP///2eZyyH5BAAAAAAALAAAAAAOAA4AAARL8MlJq70t672Z/yC4jEsBGMGAkCRSHEaiDAqBOAvCEMlxnIqZw0Z4FBKG3yGoWDwEiEcpQVUEmgvDinRM0LajEEMgZnDOmot6TYkAADs=";
elseif($tag=="tc") $tmp.="LMAAI9259q7KFKKLJ5StJSaTuLbHP49PN59l+hdcqY6jE89ywMD9wAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ78KiVpkJz6TUQSENyANuGIEZ6JqUmpodxDNl2SEkCYC3nWryecBEoEGrC4nGoMRaQPYKgwNwsq9gsMwIAOw==";
elseif($tag=="td") $tmp.="KIAAOYeHNraHCIipPhbBltbbQYGqu7uBP4CBCH5BAAAAAAALAAAAAAOAA4AAAM0WFpkbuPIs9iD84jVXpxV53xSeJEUd2abImKg6mXmHLvr1Fp2KY+0H0wiKAoIgWRgAGgCEgA7";
elseif($tag=="tf") $tmp.="LMAAP8xAM4xAGOczpzO/87O/85jY86cnP+cnJzOzjFjnP+cY2NjzjFjzmNjY////wAxnCH5BAAAAAAALAAAAAAOAA4AAAQ7sD3mVFgv6yepAtiWdc4BiuNUnShphWLDCIRRMCiXP8OApDuHRpJzMHC6IkGYRBkFwN1Qmhg2rtgsNgIAOw==";
elseif($tag=="tg") $tmp.="KIAAH6GBFZ+BP5lZvimKaDlBP4EBf7+BBHCBCH5BAAAAAAALAAAAAAOAA4AAAMsWKpx/m4xCGUB9BUh1DBgCBafJ4pbRxJsy1pNdsDyMdy3q59874O1oHAISQAAOw==";
elseif($tag=="th") $tmp.="KIAAP4OBKqu5P7+/P7KxP4KBB4mtAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMoCKSstA+yB+oCI+u9hf8gGIxkWRZoqq5s675wYc5kaH9crkV87/+RBAA7";
elseif($tag=="tk") $tmp.="KIAAAJwLAs5cVZabEJChH19VmJicZiYRQQFqiH5BAAAAAAALAAAAAAOAA4AAAM/eLrcK4aY6M4ocsLBwinFFIbM9SkQQTJFGRqKyjUTfIjzQxAxaC8AwGIgwaACHoZhVCQklZiaoOV4TXiVrCIBADs=";
elseif($tag=="tm") $tmp.="LMAAKLtoXDicIpuPNekROaYLEDYPvSIEiPTJNOFJHamBPJ+DgPMBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARAMBmklr04DVHLOge2JAq1FMECiAlCKAW4BOHVmp9aWyReAKkMYoAQsRRIo5CotCFwzQSBYGjyBlTryJC0krrNCAA7";
elseif($tag=="tn") $tmp.="KIAAP6xr/4tLv6Wlv7p6f5TU/4CBAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMoWLrc/jAqIkSINYBBHi1DODwWAQQE55RDIKiNW2whZJrwgxKX5P/ABAA7";
elseif($tag=="to") $tmp.="KIAAP5SUP6GiP42NP7R0P6bm/5xc/78+v4CBCH5BAAAAAAALAAAAAAOAA4AAAMnaDakVidKRY6DMhoCThhPpglSg2Vb94UiZSnntDSwaN94ru987+cJADs=";
elseif($tag=="tr") $tmp.="KIAAP42L/1JSP6coP5+dN4yNP7ExvAiJP0EBSH5BAAAAAAALAAAAAAOAA4AAAMmaLfc/k/BSZcyZcgpQFUFA2wMyAjBVJDRERQBG3mTXN2Eoe/8ngAAOw==";
elseif($tag=="tt") $tmp.="KIAAFdXV/5cVOqZlP4gFKyXlhYWFAICBP4MBCH5BAAAAAAALAAAAAAOAA4AAAMyKGVGczDCQVgRMgfAQMiSwjjgVBlXCW3dp4rNU1IWprKGpx4wOZ+pGyfnKvVkIBpKkAAAOw==";
elseif($tag=="tw") $tmp.="KIAAMLC5BwcrJqa2Pb29Dg4tGVlyAkIpvUCBCH5BAAAAAAALAAAAAAOAA4AAAMjaLp2/keRQhR8qoBibwzCIASNl23dJVEpxCxeLM90bd94ngAAOw==";
elseif($tag=="tz") $tmp.="KIAACIhDKqaJaWwBiMjmhkXBAICBAUFmgWbBCH5BAAAAAAALAAAAAAOAA4AAAM7eLp8AqW1V6JUtJDroA5XRgSDJBDVOBgT+hkwc1YACbOYO97xEeg2nsNV491mLyOMGFDeAFDBYEqtJgAAOw==";
elseif($tag=="ua") $tmp.="KIAAP7KAACp//7JAACp/gCq/v3KAACq//3JACH5BAAAAAAALAAAAAAOAA4AAAMqOLob6iTKOZm1NMvAuzedIY5kaZ5Hqq5s6wpwLMtFbd94rs9A3PcClysBADs=";
elseif($tag=="ug") $tmp.="LMAAOfnACEQEOchGOe1OXtzY+/n5+8AAAgIAP8QAAAAAP8AAP//AAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ2MMlJ6bk4Z7C6/2AYImSJDCZpKCxbFELLrrPxFrVRJW9QaYcEAcgRGY8dQ2qpkjllhqh0Oo0AADs=";
elseif($tag=="uk") $tmp.="KIAAKWlzoRKjP9jY2tjre/n7xAIjP+MhP8ACCH5BAAAAAAALAAAAAAOAA4AAANMSFA8Z4wJc1Q7Ik4S6nJQsF2E8hRjEQyAUD6GQQyDGN/YjR987/9AoC6WG9JKLkzJQBsUBgTB6kQwZJ7RwPNUqGayFwjDe9BermNDAgA7";
elseif($tag=="um") $tmp.="IAAAO/v7wCt7yH5BAAAAAAALAAAAAAOAA4AAAIajI+py63gAoAQTUklm7emvGXgo3kkFqVqVAAAOw==";
elseif($tag=="us") $tmp.="KIAAGJPrGMgfImCyP6Mjf5ZWxsbpP7Rz/4XGSH5BAAAAAAALAAAAAAOAA4AAAM4WKpx/m4pYKqtsjT4Mr1WFhDEQZqENxjD2g4iKRMDIdz4q+983c5AIKviIhpLpqQDWQI5LZzoIwEAOw==";
elseif($tag=="uy") $tmp.="KIAAMLCEIqK/M/PLKGh/Lm5/NbW6gIC/Pj49yH5BAAAAAAALAAAAAAOAA4AAAM4eLrcV0WVQGs4IotDjP8GpklPGQkAsBXE4L5PFnWgt0QSpLNE7/++mvADLPp2SORw+Go6XY7oIQEAOw==";
elseif($tag=="uz") $tmp.="LMAAG5utxIShBsbjJaWzK6u1EpKpDc3nEpCDEoKRAICfQJ+BP7+/AAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQwMIGQqr1yJlEMroOXFN2XGIRgkCKGvHAcL3Rt33iu7/xy/MBgUEEsGo/IpHLJVEQAADs=";
elseif($tag=="va") $tmp.="LMAAKWcOYSEKc6lpcbGAMbGnM7Ozu/v3u/v7+/vAP//////AAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAARBEKlJTbpY0nlw3px3aZuVFMQIKlYAAEFCUh1BDIO8dglRqCCDYSAQFA6zUMLwQ+4wvCRLpAtSpTzPAMHtHg9gcAQAOw==";
elseif($tag=="vc") $tmp.="LMAAO/vAM7vAKXWAFK1AHPGAAiUAACEAACMAAgIrff3AAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ6EEmUqk0nT3prPlvnaVMFVAFGSslQJIKhgmWmAl9oyMYxh4BY61fypIisBOEgQ3Iwllwx0XSKrKJPBAA7";
elseif($tag=="ve") $tmp.="KIAAGxs/E9P/DAw/LYCTLa2TAUF/PYCBP7+BCH5BAAAAAAALAAAAAAOAA4AAAMoeLrc/jDKQ6q9t2gdCijCJoahJnQimKrit3raIM80bdx4ru987/+GBAA7";
elseif($tag=="vg") $tmp.="LMAAG9v6T0wvMGsxZSS2ktJ03k3grYFDc6MnqlQeYKqcMBviQICvAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ5ECyEVjkr66UGLUKwacqhIIc5ZkbrGuuSKopwSFmSZEdBAQpRbmexVAgKjS42WjKVxCcnKa1ar9UIADs=";
elseif($tag=="vi") $tmp.="LMAAPcQEN5rOc69nCmUtQCc1iEQnDm9QtbeEEK1zu/va7XW3u/v9+/v5/f3AP//9wAAACH5BAAAAAAALAAAAAAOAA4AAARakLlJK10t1VZTW04jTpxziInkjdw5MopyJkWtjAqDIIZXDyeEA8EgKAy3AEDQ0A0XCofB4FAyEgrCUDLpMQCMg9ax4Eozp9ClIgiJKyALJ0oxWyz2yWLPX0QAADs=";
elseif($tag=="vn") $tmp.="KIAAP6iBP5UBP7SBP68BP46BP5vBP7yBP4NBCH5BAAAAAAALAAAAAAOAA4AAAMgeLrc/jCuIpegsIRiRgiEQxgkOUQlIKVRoRJCFFZ0bScAOw==";
elseif($tag=="wf") $tmp.="LMAANZaWPbY2NBGSM46OsgoKd12d+CChP38+snD5sUYGQUFrL4CBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ4UCl0yroYS2pWytpUgdl2dB9pWtkAAItpJGkyBMBAYkSQGJ3dgoAgFII7W6BAEF4IAoFzSq1aLxEAOw==";
elseif($tag=="ws") $tmp.="LMAAA4OxB4exBQUxH5+3Do6zG5u3FZW1HZ23LcCNCICpAICvf4CBAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQqUMkgJVoY11LVzYtiVIMFhsQEmKC0CtWXSccan0mu5/Lp/8CgcEgsGk8RADs=";
elseif($tag=="ye") $tmp.="JEAAP5qbP7+/P4CBBQUFiH5BAAAAAAALAAAAAAOAA4AAAIelI+py+0Copwz2Iuz3rz7AAzhKJbhgKbqyrbuCw8FADs=";
elseif($tag=="yt") $tmp.="JEAAP7+/P4HCQcHtgAAACH5BAAAAAAALAAAAAAOAA4AAAIklA0JwXyomntqySeqDFhfGn2H13RhCSabqYpQi47nJMP0azUFADs=";
elseif($tag=="yu") $tmp.="KIAAP9aWmpq2QAAv/////8AAAAAAAAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAMeKLrc/jBKEaq9d+jNu/9gKA5AaZ4noa5s675wLBMJADs=";
elseif($tag=="za") $tmp.="KIAAHp6/P5QUrjGXltVjpLJkv4JCgQEvQaGBSH5BAAAAAAALAAAAAAOAA4AAAM7eCdR/lCtBqGQrL5xVdYGhwVkGRhhdxBsS6CpJCuwOEuovbpsrBCAgXCoIwxgSJXgiIRJgE3kjxlFJQAAOw==";
elseif($tag=="ze") $tmp.="KIAAO46BMFmBP0NBIfLBNqSBFvBBOTeBAm1CCH5BAAAAAAALAAAAAAOAA4AAAMveLrc/m0YM+CR0xQ4iTdPMQkCADoiQQYaahCAQJxN+k7QwGZQEcytXmBQsRiPigQAOw==";
elseif($tag=="zm") $tmp.="KIAAOIpERQdD38fDPaZEDuQEql9ECqODBCgDyH5BAAAAAAALAAAAAAOAA4AAAMseLrc/vCQUgaJilzMjylCUBmPAYRVSZziAJmo6xhrTM5sOtftm1ueII1XSQAAOw==";
elseif($tag=="zw") $tmp.="LMAAL1zIcK+POnZ2XCQcMZKHH5ydKKdWdS+rvQzCfPy8AoCBO0CBOPYBAyYDQAAAAAAACH5BAAAAAAALAAAAAAOAA4AAAQ+cLRJK002zyQC+2DIJIknismREEvrvglwCG+9HACQDErv+wmDIVH4GYOGgw1GIiCe0CjJdAKlqiKBJiPZViIAOw==";
else $tmp.="KIGAJmZzMzM/zNmmTNmzGZmzAAzmf///wAAACH5BAEAAAYALAAAAAAOAA4AAAMhaLrc/o2UOeC884kSTMiQAhREaAwgJJHmVpgwc8FzbD8JADs=";
return $tmp;
}

?> 