<?php
if(!isset($_GET)) $_GET=$HTTP_GET_VARS;
if(isset($_GET['q'])) $q=addslashes($_GET['q']); else $q="unknown";
$q=str_replace(" ","-",$q);
header('Content-Type: image/gif');
echo base64_decode(image("$q")); 
exit; 

function image($tag) {
$tmp="R0lGODlhEAAQA";
if($tag=="Avant-Browser") $tmp.="KIFAP8AAP///8bGxoQAAISEhAAAAAAAAAAAACH5BAEAAAUALAAAAAAQABAAAANAWLDcrS7KRsikIYsLNBHBJmXEYGoRWC4g2oBb+7mLRppEFi75PSyDlqgn+DWCK4AwYjIqSRxWIMkpOS+QKKCQAAA7";
elseif($tag=="Explorer-4") $tmp.="LMAAAAzzDNmZjNmzDNmmTOZmTMzMzMzZjOZ/wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAQABAAAAROEMlJp6lYjnHzLAJQFB11nChRYAVxDC56IOv0IodgxHlZBLiZhFejIWLIFGUga55MKI9FNmGeBpKCk3eTGA5f53PqbZay4ALHwPaEz5gIADs=";
elseif($tag=="Explorer-5.5") $tmp.="PcAAIb//+zfnOjWecLV6NfTqbvU8bvU7rvW3LrV3mzw/67O7qvF6Fzm/6PE7LK84KK/6KS+5pa290DZ/zzb/4e356en4ZqwyC7c/4Sw+IW00Jyl5oep8q6koTHQ/56X4rOlWJmZ1XeZ/5KR03enmoyP2Y6P02ei3ZeWk42O0wzC/2KgvoiI11uc3l+gs5KLlWmUzwW9/xS1/1+Yy1KX3GCVwlWR9Tqe9Dad9wqw/3x/1U+T5n191nmA0nt/zlGM8FiJ5oqIW1eC/kySxCaa6x2b6ACl/0+C3yaV7F99xyyR6DWN4jyK2AOg/j6H2WV5ukSB43V3kAeb9CaP23N5gzqE3gWX+BSU5gyV7CaJ4UJ91AOT9iyC3iuA3zB6+G1vfkN03RGL4k5q5St3+CR+205rzEVs5iF67i531UxpzTpo/ytx6ACF8QCG8DFy1Tdn9DJs5V5euiN06DZm/zFn/gqA4gCA8DFs3i5m+ixn+RJ36CVt6iZt5Tlm2idp9ytm+Cdo9idq7CFu6C9j8mJjXWhiV0NisSZi/iZg/wF45Ap12Btr3zpnmTRX9yhi2x9m4S9nsh5f/xlm4y9Y8Spd4hBq4BNl8UtZiQ9ozBBqsTxXqEdTkRBmvg5kwx1euVlUShFkvFlVSFBRZitPuBhZrT9JdABZxyZJrAxUrg1UogpOrj0/ch5EkgY9uABKdhswjRMvmwA6hhUikQ0dqgUHgP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAUUALQALAAAAAAQABAAAAjuAGkJHEiQVoQgIagUHFjAAAYfGwQqWEJwQJM9bwBhuXKEgsAZAzWUOmPBSBciRWBUSUKLhUAPrFoQ+BGnUR4cEi4w0bFAoKwRAcoEakCrQqIOACYoEbjCi4Awh0wMhGMlAYMhAqF8cALpjh41XKTQ0RIjRZQHtIBMMcTJDyNJdsaAWUMXEYQTg9x0QvWHjAgUJUD0yLGDBy1Cliq5GkWpxkAHX27Y2HIAFJpUs0x96vNEhYxJc8SYEULLEx8apGKJ2qQoEp40aQRlEcjhkUAXql6dwnTJUZsMBDO9ELgolKZCSBAspLWqFSwSywcGBAA7";
elseif($tag=="Explorer-5") $tmp.="MT/AAAAnwAAgDAwzzAwn2BgzzAwYDBg/wAwnzBgzzBgnwBgz2CfzwCf/wBgnzCfzwDP/2D//2Cfn5///5/Pz5+fYP//n8/Pn8+fYP/Pn8DAwMDAwHBwcF9fXxAQEAAAAAAAACH5BAEAABkALAAAAAAQABAAQAV/YCaOZKacSrZZF5IYaIyKwhBppyAoD8SkHEGmMBC8FIZkslE6KQ2On8iQEVAwydRIAHn8OBTEIIEkCZRMATNz6ACMjXVpJNOatorF5BSN2jM2FTBaAg4SEForBAhPDlEMkAobFwZGMHMjHAgHAZaETw0bQhkdHUZkS3JVOpgkIQA7";
elseif($tag=="Explorer-6") $tmp.="PcAAIb//+zfnOjWecLV6NfTqbvU8bvU7rvW3LrV3mzw/67O7qvF6Fzm/6PE7LK84KK/6KS+5pa290DZ/zzb/4e356en4ZqwyC7c/4Sw+IW00Jyl5oep8q6koTHQ/56X4rOlWJmZ1XeZ/5KR03enmoyP2Y6P02ei3ZeWk42O0wzC/2KgvoiI11uc3l+gs5KLlWmUzwW9/xS1/1+Yy1KX3GCVwlWR9Tqe9Dad9wqw/3x/1U+T5n191nmA0nt/zlGM8FiJ5oqIW1eC/kySxCaa6x2b6ACl/0+C3yaV7F99xyyR6DWN4jyK2AOg/j6H2WV5ukSB43V3kAeb9CaP23N5gzqE3gWX+BSU5gyV7CaJ4UJ91AOT9iyC3iuA3zB6+G1vfkN03RGL4k5q5St3+CR+205rzEVs5iF67i531UxpzTpo/ytx6ACF8QCG8DFy1Tdn9DJs5V5euiN06DZm/zFn/gqA4gCA8DFs3i5m+ixn+RJ36CVt6iZt5Tlm2idp9ytm+Cdo9idq7CFu6C9j8mJjXWhiV0NisSZi/iZg/wF45Ap12Btr3zpnmTRX9yhi2x9m4S9nsh5f/xlm4y9Y8Spd4hBq4BNl8UtZiQ9ozBBqsTxXqEdTkRBmvg5kwx1euVlUShFkvFlVSFBRZitPuBhZrT9JdABZxyZJrAxUrg1UogpOrj0/ch5EkgY9uABKdhswjRMvmwA6hhUikQ0dqgUHgP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAUUALQALAAAAAAQABAAAAjuAGkJHEiQVoQgIagUHFjAAAYfGwQqWEJwQJM9bwBhuXKEgsAZAzWUOmPBSBciRWBUSUKLhUAPrFoQ+BGnUR4cEi4w0bFAoKwRAcoEakCrQqIOACYoEbjCi4Awh0wMhGMlAYMhAqF8cALpjh41XKTQ0RIjRZQHtIBMMcTJDyNJdsaAWUMXEYQTg9x0QvWHjAgUJUD0yLGDBy1Cliq5GkWpxkAHX27Y2HIAFJpUs0x96vNEhYxJc8SYEULLEx8apGKJ2qQoEp40aQRlEcjhkUAXql6dwnTJUZsMBDO9ELgolKZCSBAspLWqFSwSywcGBAA7";
elseif($tag=="Galeon") $tmp.="OZvACI6Wt7e3oKCgraytbi2tlJSUN7a3s7OzmJmYiI+W3p+egICAtba2SIhHEpCOhIODkJxqf764ebi5WJiYdbS1ebm5c7KzRo+V5aSlramodbW1ra6ru7o5nJeWvbt8K64soKZb+vVoypGYsPJo4qWpgoKCs7Gxra+vjpGWneOoVJ9pkplfWJqZZqqxlyPwSZOckpNSkI+OruqgkI6NYqegnJyb/788jpCUmKStvn2466qrWp6ckJunjI0NjpSZtbarqq+3lKLvr66vVdiYho5UZaqplp6nrPH3mJocn6OZkp6tlZmcnp0cEpWWoJ1anJ2cc7S1paPemqOplpmYjI+SmppaZ2dnkJaWq66ziFBalJqcmCLtDJehqaelqampmJWTc7Gpqaipfbm7r6+viJCWqaSimp4enqWsn2HiipSfYKanoiPjO7q7q6igiI9Uv///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAG8ALAAAAAAQABAAAAfBgG+Cg2IZFIOIgwYHbx4YDQGJiGNfTBlOCwKSgx0PJQ4NmZtvZScKBG8DBAabXQ5egkBSNCBJG4kMEwNvWDkRaDBVa4yCHCYzby02EVEFGAcSiBYPC0c4Iz8FqG8MJCtCFW8BA1tBLkUIGhJTO1dNSLuCEEoqajUaFAgsIm4omoJneEAA0waVBShkiPT4J8gIlxQhZGgZkgAAlQIfEBl4kcaMjywVAcRQEAkRmyUJLgBQecNKOEkBdChAMOFJmEGBAAA7";
elseif($tag=="Konqueror") $tmp.="LMIAJmZZgAAM////8zMzGZmZjMzM5mZmQAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAAgALAAAAAAQABAAAARKEMlJq52DmHIuGpIxDEdxGSgqEAdYqUMxHsRVGEAgs25FCIZSsHb5BUslj/HAZJosywLHCQUmj0RKNJTVWp8eRMHavQw25bAaEQEAOw==";
elseif($tag=="Mozilla-1") $tmp.="Pf/AP/////28//y8P8qBP8qA/8pBP8oBP8oA/8nBP4oBP4nBP3j3v0oBP0nBP0mBPzt6vzq5/zj3vwoBPsoBPsnBPgnBPcmBPUmBPMlBPMkBPLTzvEmBO7Nxu3d2u3RzewkA+sqBOshAOra1+rEv+nEv+gkBObIwuYkBOYjBOUjBOUiAuMjBOG/uuAiBN8fAN7Oy90hBNwiBNohBNm4s9kgAtYhBNWwq9OwqtGrptC2s88gBM6qpc0gBMwfBMweAsofBMmloMcfBMYeBMUeBMSjnsIeBMGemr8eBL6YlL6Yk74eBL2bl72TjL0eBL0dBLujnruZlbqYlLkcA7WUkLSXkrOTkLOSjrKZlq+Wk66Nia4aBK4aA62Sjq0jDa0bBK0YAquRjakbBKkVAKgaBKaYlqKDgKAZBJyAfpx/e5sWAJsSAJsRAJocB5kbB5h9e5eFg5Z6eJZ4c5SEgpNybpMYA5JybJJxbZF2c5BxbY8WBI4YAI1ybo1xb40WBIsWBIpwbYoWBIkXBodnZIcVBIcUA4ZmY4VraYVlYoUMAIRkYYQ7L4FpZ4BqaH8RAH1nZX0WAHwTA3sMAHpqaXgfEnYPAHVjYXQbDHQPAHESAnBdXHASBW9bWW0SBGwRBGsmHGgYDWcMAmVRT2ERBl5TVFsjHFoOAFlNTFgUClcOA1YdGVUMAlRFRFQHAFE/PE0MBEwgGko/P0gMBEczMkYIAkYHAUQ8PEItK0E3Nz0KBDsZFDkfHTkKBDgwMDcUETYFADMJBDIcGjIVEjEJBC0aGCwPDCsRDygHBCQKCCIzNyIdHCIFASEiIyEgISEFASAEAR4hIR0hIxkVFhgTExQAABMDABEQDxAZHAsBAQMPEgIAAAEBBAAAAwAAAMDAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAAN0ALAAAAAAQABAAAAjUALsJHDjwjTVJBBPmsDXJljI6g2olHLhp2qlGjYKcQMUrR0IywJYp4sQmiB4taWx57EYGViQtp9ic4ITryIcBZpY9kZXGxYABHwYd6aEliA4EJ6ohy/MTKadfWiz8HFTDAp1iPRB86NIrW7ZZUmEo0zEgiC02lmwhi4bKVZABCLT8InuKCzZrnuhESlNjwJFBJ94eqdbtzSo9ijZVKubrVxAEcGEcG7iDcq1ZJ+AisDB5YrccorScQLC5mGeBtihlhmzpdLdKrGqQHtDFdaVTkyyEDQgAO4YHTpOCUJBxYQpxgcwJUaqiwSmT5zRkxACUqA6P0kUCAgA7";
elseif($tag=="Mozilla-Firebird") $tmp.="NUAALq6usrKyq0ZF441NI0JCI1RUelhEayOjXx8fJx+fpxiYaxGRI0aCbwSCp0oJqucnH8JB6xPGqwpJ7tODqt/f41hYF4xMZ1wb5uJfruxrE8bBqs8DF5eXqtHDZwgCp0KCcwNC7xWG28SB34TCKwxC8pUD5ubm/f396wnC501NJx3Yl8MBm1bULwiC9paEG1IM+np6bwMCq0LCdnZ2flnEusPDPsQDf///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAQABAAAAadwJtwSCwWT0ITa2Y0wm6YUMbJvAU4t1kpwpw9b4dDVgAABFw01Y2SEKYct4sNkHjRaBGYQyKM1SoSNgUDKHcGFjYgTDE2NYw1BC13NI8ACASNjI0iBneMBAgKMjYjMjU2qAwGHacyCjMCNhsaH6ipHqgCMwEQNiQTMpqNpzYQATcFNg3Ats2CQjADNQ0rzo0DX0IPC8Ey3QsPTeJEQQA7";
elseif($tag=="Netscape-3") $tmp.="KIEAP///wAAAH9/fwAAi////wAAAAAAAAAAACH5BAEAAAQALAAAAAAQABAAAANISLrcOjBK+aCwOL4L7vACAFUD0EVCOBJXaKaROGxleXKrJbrtuampF1DR+3xeO+KxdRQSg7AUT/AMpALYbFah7Xa53rBjzEgAADs=";
elseif($tag=="Netscape-4") $tmp.="KIBAAAAAAAAAJkAAAAAzMzMzJmZZpmZmf///yH5BAEAAAEALAAAAAAQABAAAANuOLoDvK7FEaYDRwUBOunNZmQKUQQBERQC0Y4LcXAV4BIjWbgHBhQ2zIHkcqSAh83wQFAJUsxmCvXxAAQCA85XNGgcQEESIIINWsBrb7uMhVk7loy0ejYNAlYFlgcYfhxCWTA2OVlzS0NCiX6JSwkAOw==";
elseif($tag=="Netscape-6") $tmp.="MQAAMXLzw4aIlppbQhHTwhuZbK/x+3z973GyWqLliJtbZS2uAcvP1mPlXCZoWN5gSOAdzyIhpSTk6nJys7e4XitqZbCwb/Z2KClqCtWYN/n6pKqsgJcVrTP06CkpgoKCgAAACH5BAAAAAAALAAAAAAQABAAAAWfIFCMZAGc6JE5weK+sBt0yDJg2KDr+OBqNYxmgtgJCgeBD2jDGAyOXUOhWwAHm4TlMIFsBlPsQFHcPDiJyuSxmW6+isaG8LAkEhzLo1EhEDZxc3UPBBATEgp9fwoUdBAWEA8PDBkGFZIEFRR3lFE+GAICdwkSLAsIBw4eH6ysAa8dAq6vq622EbK2urcCHr6/wMARBRcdHcXGxsgXFwchADs=";
elseif($tag=="Netscape-7") $tmp.="OcAAGqXlluMjE6EgkR8eEB4cj5zbXyhp3KgpGacn1eXlkuPjT+FgDZ8dTV4bzhwaDpoYnaVoH+lr36rtXOkq2Geok6SkkOEhD19ezt3cjlwaztrZzdhXXmbom2Wn4ewu6jL1ZW1v2WXnVKPkkeEhVWMjXWhonqfn1N6eDtjXzxdVF+MkV6VnHCjqa7P09/z9ouss1aKjkKAf0iCf4ixsJ28vE5wbTZiWThcUV6EhU2Hh06TlFqYmIuztNDk5dnr73SaoEJ+ezp7c2WYknKalT5rYjFoWjdfUjtWTVOAfD2Bf0GJi0uIjnurr4uysqzIytHq62SLiUNybGmXj3KdkztkWzpiWDRcTzlXTEt2cTh8eDZ9fz9+g2uhpHWmpU57eK7Qzsfm5Fh6dm2QinaZkT5jWzddUzZaTjhVS1N2cjp0cDh3dj12d2udnXSloUB1bk58dbjW08bb2Ymdm3qSjjxeVTNcUDdXTDtTS2N+ekJsaEZycUxzdICioourqWqNiWeIhH6Tkdzn6N7n54uZl0piWjtbUD9RS32Oi42ioK/CwcDNztrk5cHHyXqBhFlfY1xfY19hZF5gYVxjYV1qZWl5cmd1cFhkYLK4tlldW1FQUH95en52eFdOUy4nLiokKionKicmJyYnJSYoJSQoJCovLnRzcDUzLysoJCwmIy0kIyolKConLCgkKCklJysnKCwoJyonJCUkIERDQ3h3cjY2MiUkISknJCcpKSUoKCkoKiwpKismJysmJiwpKFBOTI6OjVpaWi0tLSkpKSgoKCkoKUVERGlpaZqamoKCgnJycmtra3Nzc////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////yH+FUNyZWF0ZWQgd2l0aCBUaGUgR0lNUAAh+QQBCgD/ACwAAAAAEAAQAAAI/gD/CRQIIICAAQQKDFz4z8ABBAkULGDQwMEDhhAiSJhAoYKFCxgyaNgwkEMHDx9AhBAxgkQJEydQpBCoYgWLFi5ewIghYwaNGjZu/MORQ8cOHj18/AASRMgQIkWMHEGSRMkSJk2cPIESRcoUKlWsXMGSRcsWLl28fAETRswYMmXMnEGTRs0aNm3cvIETR84cOnXs3MGTR88ePn38/AEUSNAgQoXuGDqEKJGiRYwaOXoEKZKkSZQqWfp3CVMmTZs4dfL0CVQoUaNICSxl6hSqVKpWsWrl6hWsWLIGzqJVy9YtXLl07eLVyxfDX8CCCRs2jNiwYsYYDjyGLJmyZcgYAgYEADs=";
elseif($tag=="Opera-5") $tmp.="JECAHt7e+8YGAAAAAAAACH5BAEAAAIALAAAAAAQABAAAAIxlI+pFu3LWgzrHYuw0Fs7enmiFErA+QFlcE5sm8LPCcQyiJJ0TQo86KNZOMEfEZIoAAA7";
elseif($tag=="Opera-6") $tmp.="MQfAJsYGLEYGN45OchKRM4xMfd7e+9mY/eUlN5zc60hKb0pMfdzc4wYIYg+NZwhIf+cnM45ObUpKfe1rdloYN5KSudaWv/GveeEhL0hIe+hnMZCQtY5ObUQGGMhKXt7ewAAACH5BAEAAB8ALAAAAAAQABAAAAVm4CeOZGmKnYNx3Haiift1gFzSENkFggkMFV3rdsgUhMNRB2E5Klm22eDiREE/nmwnohF4ngpDFhXgeMedwWSR/XZYvXZnkhG3P4xktiF5iNoeNAQjHg0TBoRyAINSFCaKLByML5QhADs=";
elseif($tag=="Opera-7") $tmp.="MQfAJsYGLEYGN45OchKRM4xMfd7e+9mY/eUlN5zc60hKb0pMfdzc4wYIYg+NZwhIf+cnM45ObUpKfe1rdloYN5KSudaWv/GveeEhL0hIe+hnMZCQtY5ObUQGGMhKXt7ewAAACH5BAEAAB8ALAAAAAAQABAAAAVm4CeOZGmKnYNx3Haiift1gFzSENkFggkMFV3rdsgUhMNRB2E5Klm22eDiREE/nmwnohF4ngpDFhXgeMedwWSR/XZYvXZnkhG3P4xktiF5iNoeNAQjHg0TBoRyAINSFCaKLByML5QhADs=";
elseif($tag=="Phoenix") $tmp.="OYAAGspKTEYITkpKUIxMd5aMZQxMXut5ylCUsZCQkopKWucxvd7SrUxMdbe5+8xMTlSc60xMe+EY85KSr0xMc5aQjFKWjExMaUhIecxMe9CMVqEpVqErUJac60pKfdzUlJznHut3udjOWNaWs5CMSkpKc4YGHOlznOczhgYGGNjY1p7nGMQENZSMa1CQmuUvTlSazlac1JSUnMpKa2trYwICHNSOd4xKd4pKd5aSnu153sYGEJjezFCWveEa1p7pc5CIfeUe60hAHNjY2shIfd7Wv+UAMYICLXW77UhIVIpKSEhIYQxMYQAAO9rQr1aQu9rWkIpMVJ7nAAAAP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAAAAAAALAAAAAAQABAAAAfjgFMmJwoKUYeIhxw7UycmU5CRkpAVPApTRzkGJTo0F0sFAhsbUxUuUwYGIEpDKwRNSzUpARpSUVMgDkYkMx1PP08IJAFQU0AlGAssExATFyEEOAwoUFAoCx5NT01OT0422hACA1My3U4iSkrbER0hDAnVC05KQkpOFNoSSEQFCTFTogAQ0c2bEwlBEBBgEGAAlFsQAEgEsCSDhwg3EggodkuDjw8NXlho0aNJAQdKmAScoiJKgwdSLORzkAFDkmIcpoCEWWTJCAQjlgQIoBLGgSkwmTCB4nCJUpWQDhyQMqnqlEAAOw==";
elseif($tag=="Teleport") $tmp.="KIFAAAAAP///wAA/wAAhNTQyAAAAAAAAAAAACH5BAEAAAUALAAAAAAQABAAAAMuWLrc/orAyYS94tnB+7CVJ3JZIYzfRZrj2Z2Z68nfx7aqfaPrsuEaDIhCLBodCQA7";
elseif($tag=="Voyager") $tmp.="Pf/AP/////+///8///8+v/7///6///59v/4///49v8AAP78/v3//f34/fz//vz+/fv6/fv4/Pr///r9+vr0+/oAAPn/+fn+//n8+fn7+vn5+fn4+fn08/j9//j6+Pj67/j59fj4//j4+fj4+Pj3+fgAAff49/f09/cAAPYcHPT+//P89PP7/fP38/Lv9vH5/fH3/vHt9/EaGPEXGPD6+PD4/fD47/Dt9vDs9u/4+O/x7+/t9e/t7u7m5+4AAO3u8ezTyuwKCOrs8+ra0Onm5+fo5+fm6efRzOfQyubs8+bOyuYBAOYAAOXNx+XGwuTOxuQcFuQSD+Pp6OMQD+De3t7JzdrNy9oZFtna8dfU19bU19YADdW7uNUAANSmo9IAANBDQM4AAM22tMx2b8rIycq5uMmNiclTUsdHOsc8N8aBfcUAAMPFwsLCxcHD6sDB6sBYT78ILrgrVLUAALIAAK4AAK2t5KwUS6mfrqcAAaOioaKk05qb4pcAAJYSEZWa4pST35OU4o+P4IeIhoaIhIZvbH+M5HoZFHkAAHR2dGJi1V5h110AAFdczFJT0FFWU1FS0E0AAExO0EhGRUcAAEZIQzoGiToBXjlCQDQ9zzAEbjAAEy4xzCkpJiAAABgBGRYiIBUAABQjIhQathEAABAWwg4aGQgBeAYPywIRzwIOywIAAAEPDgELyAAHzwAGnQAFzgAEbgAEZQADlAADAwACAQAAAMDAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACH5BAEAALYALAAAAAAQABAAAAjMANcIFDhmD6NEa8YMXGPLCJMkSagA2hNoE6k7P5I0IYNlzJknKOL4QdJG0alMIPtwGoMlTYIEdgq1qRPplCkuPUBRmrIGy5kEcDApakSqVSwuh1YJtLWmDJAElVCdauVKkxpQjqbY2jrmSwItlmTB8kRnUamlW9eEgZJACR4+YLioQqR161Ysb17qhfQJCxm7abc80StHlSAsgO2uMXPi5aS+DBMzJWMlQWFBYyTbxSJGSadLRCJrXsPEkKo8mTXbHUNop2rAa6Z0lBwQADs=";
else $tmp.="KIGADNmzDNmmczM/5mZzGZmzAAzmf///wAAACH5BAEAAAYALAAAAAAQABAAAAMjaLrc/jBGUiqQNdcYijDCJilDQYwGIEqUiXYFKjOZXM94DiUAOw=="; // ?
//else $tmp.="IAAAP///wAAACH5BAEAAAAALAAAAAAQABAAAAIOhI+py+0Po5y02ouzPgUAOw=="; //GIF TRASPARENTE
return $tmp;
}

?> 