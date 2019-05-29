import cv2
import numpy as np
import time

cap=cv2.VideoCapture(1)
#fgbg = cv2.bgsegm.createBackgroundSubtractorMOG()
moto=0
car=0
truck=0

for x in range(0, 50, 1): 
	_, frame = cap.read()

while(cap.isOpened()):
	
	_, frame = cap.read()
	#fgmask = fgbg.apply(frame)
	
	gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
	ret,thresh = cv2.threshold(gray,128,255,0)
	contours, hierarchy = cv2.findContours(thresh,cv2.RETR_TREE,cv2.CHAIN_APPROX_NONE)
	
	for c in contours:
		x, y, w, h = cv2.boundingRect(c)
		if w*h>1500:
			cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
			if w*h<4000:
				moto=moto+1
			elif w*h<8800:
				car=car+1
			else:
				truck=truck+1
				
	print("moto" , moto)
	print("car" , car)
	print("truck" , truck)
	print("-------------")
	#print(len(contours))
	moto=0
	car=0
	truck=0

	#while(1):
	cv2.imshow("frame", frame)
	key = cv2.waitKey(1) & 0xFF
	if key == ord("q"):
		break
	
	#break
	
cap.release()
cv2.destroyAllWindows()
		

