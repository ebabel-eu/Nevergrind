<?php
	// DELETE CHARACTERS:
	delete from characters where name="Nerevar";
	delete from item where characterName='Nerevar';
	delete from quests where name='Nerevar';
	
	select * from item where slotType='bank' and slot=7 and email='icewinddale23@hotmail.com' order by slot
	select * from item where slotType='bank' and email='deel0410@yahoo.com' and name='' and hardcoreMode='false' order by slot
	select * from item where slotType='bank' and email='deel0410@yahoo.com' and name='' and hardcoreMode='true' order by slot

	select difficulty, crushbone, estateofunrest, cazicthule, nagafenslair, planeofhate, planeoffear from quests where name="Fitzor"
	update quests set nagafenslair=5, planeoffear=2 where name="Fitzor" and difficulty=0;
	
	// UNLOCK QUESTS:
	update quests set
		gf1=10,
		greaterFaydark=4,
		lf1=10,
		lf2=5,
		lesserFaydark=2,
		bb1=12,
		bb2=8,
		bb3=4,
		bb4=0,
		blackburrow=4,
		bf1=9,
		bf2=7,
		bf3=7,
		befallen=4,
		crushbone=4,
		nj1=10,
		nj2=8,
		nj3=8,
		nj4=2,
		najena=4,
		ug1=12,
		ug2=8,
		ug3=8,
		ug4=0,
		upperGuk=4,
		estateOfUnrest=4,
		castleMistmoore=4,
		lowerGuk=4,
		cazicThule=4,
		kedgeKeep=5,
		permafrostKeep=5,
		nagafensLair=5,
		planeOfHate=2,
		planeOfFear=2
	where difficulty=0 
	and name='Oggrogg';
	
	update quests set
		gf1=10,
		greaterFaydark=4,
		lf1=10,
		lf2=5,
		lesserFaydark=2,
		bb1=12,
		bb2=8,
		bb3=4,
		bb4=0,
		blackburrow=4,
		bf1=9,
		bf2=7,
		bf3=7,
		befallen=4,
		crushbone=4,
		nj1=10,
		nj2=8,
		nj3=8,
		nj4=2,
		najena=4
	where difficulty=0 
	and name='Astro';
	
	
	
	// kickstarter ring
	update item set name='Kickstarter Ring',
				itemSlot='ring',
				rarity=3,
				xPos=0,
				yPos=-512,
				allStats=7,
				globalHaste=-70,
				castingHaste=-70,
				fear=12,
				cold=12,
				stun=12,
				silence=12,
				expFind=5,
				goldFind=12,
				flavorText='\"Thank you for your supporting the campaign.\" Maelfyn Sinifay', 
				lightRadius=10 
				where email='deel0410@yahoo.com' 
				and slot=9 
				and hardcoreMode='true' 
				and slotType='bank';
				
	// kickstarter trinket
	update item set name='Kickstarter Amulet',
				itemSlot='neck',
				rarity=3,
				xPos=0,
				yPos=-64,
				hp=25,
				mp=25,
				hpRegen=5,
				mpRegen=5,
				flavorText='\"Thank you for your supporting the campaign.\" Maelfyn Sinifay', 
				allSkills=2,
				allResist=12 
				where email='ng@test.com' 
				and slot=2 
				and slotType='bank' 
				and hardcoreMode='false';
	
	email: chris.chegwidden@gmail.com 
	class: Warrior
	
	update item set name='Seething Myrmidon\'s Gavel',
		itemSlot='weapons',
		type='smashed',
		damage=85,
		delay=4800,
		rarity=5,
		xPos=-640,
		yPos=-704,
		enhancePhysical=33,
		str=55,
		haste=-280,
		fear=35,
		cold=50,
		leech=32,
		attack=50,
		critChance=12,
		critDamage=36,
		physicalDamage=120,
		allResist=20,
		expFind=18,
		lightRadius=18, 
		absorbPoison=6, 
		absorbMagic=6, 
		absorbLightning=6, 
		absorbCold=6, 
		absorbFire=6, 
		req=76,
		proc='Effect: Blazing Wrath', 
		flavorText='Anger is our most precious resource. -Hodap Grobin, Lieutenant Guardian of Grynnhoven' 
		where email='ng@test.com' and slot=8 and slotType='bank'
		
		strength
		armor
		life leech
		all skills
		all resists
		physical reduction
		magical reduction
		
		
		update item set name='Gaolen\'s Cauterized Hauberk',
		itemSlot='chest',
		type='plate',
		armor=243,
		rarity=5,
		xPos=-256,
		yPos=-896,
		str=35,
		resistPoison=26,
		resistMagic=18,
		resistLightning=18,
		resistCold=12,
		resistFire=55,
		allSkills=3,
		leech=10,
		haste=-60,
		critDamage=15,
		phyMit=21,
		magMit=18,
		evocation=0,
		absorbFire=12,
		allResist=0,
		lightRadius=8, 
		expFind=13,
		req=76 
		where email='ng@test.com' and slot=7 and slotType='bank'
		
		email: zzasikar@msn.com - Kyle Murphy
		class: SK armor & weapon
		
		update item set name='Plankton Laced Greatsword',
		itemSlot='weapons',
		type='cleaved',
		damage=112,
		delay=6600,
		rarity=5,
		xPos=-576,
		yPos=-704,
		enhancePhysical=35,
		str=49,
		attack=33,
		haste=-200,
		globalHaste=-150,
		parry=17,
		riposte=11,
		leech=21,
		cold=60,
		critChance=21,
		critDamage=32,
		physicalDamage=96,
		req=76,
		proc='Effect: Glacial Nova', 
		flavorText='Ofishal family heirloom owned by legendary composer of Oh Fortuna.' 
		where email='zzasikar@msn.com' and slot=8 and slotType='bank'
		
		update item set name='Malevolence',
		itemSlot='chest',
		type='plate',
		armor=262,
		rarity=5,
		xPos=-256,
		yPos=-832,
		hp=135,
		mp=72,
		enhancePhysical=16,
		critChance=9,
		allResist=35,
		absorbPoison=5,
		absorbMagic=5,
		absorbLightning=5,
		absorbCold=5,
		absorbFire=5,
		magMit=25,
		fear=45,
		silence=32,
		leech=5,
		riposte=16,
		parry=12,
		flavorText='For nobody is curious, who isn\'t malevolent',
		req=76 
		where email='zzasikar@msn.com' and slot=7 and slotType='bank'
		
		hopp.jason@gmail.com: Ranger
		
		update item set name='Jysin\'s Blade of the Darkwind',
		itemSlot='weapons',
		type='cleaved',
		damage=75,
		delay=4400,
		rarity=5,
		xPos=-576,
		yPos=-448,
		enhancePhysical=29,
		absorbLightning=20,
		silence=45,
		haste=-250,
		allSkills=7,
		attack=54,
		lightRadius=20,
		leech=20,
		wraith=14,
		allStats=25,
		critChance=25,
		resistMagic=25,
		resistLightning=60,
		resistFire=48,
		lightningDamage=124,
		req=76,
		proc='Effect: Lupine Spirit', 
		flavorText='The faint howl of a kindred spirit resonates in your grasp.' 
		where email='hopp.jason@gmail.com' and slot=8 and slotType='bank'
		
		update item set name='Emperor\'s Gusari Hauberk',
		itemSlot='chest',
		type='chain',
		armor=219,
		rarity=5,
		xPos=-256,
		yPos=-640,
		hp=133,
		mp=73,
		enhancePhysical=10,
		attack=50,
		doubleAttack=25,
		riposte=15,
		thorns=45,
		defense=12,
		leech=5,
		hpRegen=8,
		stun=25,
		runSpeed=25,
		agi=35,
		dex=50,
		wis=60,
		critDamage=24,
		globalHaste=-70,
		runSpeed=15,
		allResist=55,
		absorbLightning=12,
		absorbFire=9,
		enhanceAll=5,
		req=76 
		where email='ng@test.com' and slot=8 and slotType='bank'
		
		sahito@humdinga.com: Ranger
		
		update item set name='Sword of Truth',
		itemSlot='weapons',
		type='slashed',
		damage=29,
		delay=2200,
		rarity=5,
		xPos=-576,
		yPos=-256,
		enhancePhysical=15,
		critDamage=21,
		critChance=13,
		haste=-250,
		armor=92,
		hp=75,
		allResist=25,
		dodge=15,
		parry=12,
		riposte=9,
		doubleAttack=15,
		fear=35,
		stun=42,
		resistMagic=75,
		resistLightning=40,
		resistCold=33,
		physicalDamage=42,
		allStats=13,
		req=76,
		proc='Effect: Avatar\'s Breath', 
		flavorText='A relic from an unknown world. At times the blade seems to pulse ethereal, turning to mist before your very eyes.' 
		where email='sahito@humdinga.com' and slot=8 and slotType='bank'
		
		update item set name='Kaedorn Boreworm Regalia',
		itemSlot='chest',
		type='chain',
		armor=207,
		rarity=5,
		xPos=-256,
		yPos=-576,
		hp=80,
		mp=125,
		enhancePhysical=7,
		enhanceMagic=13,
		enhanceFire=15,
		thorns=121,
		allStats=25,
		absorbMagic=25,
		runSpeed=25,
		hpRegen=12,
		mpRegen=15,
		critChance=9,
		globalHaste=-80,
		hpKill=27,
		resistCold=41,
		resistFire=73,
		resistLightning=33,
		magMit=42,
		phyMit=25,
		flavorText='Adorned by captains of the Kaedorn royal guard, its boreworm weave design was considered revolutionary when first revealed.',
		req=76 
		where email='ng@test.com' and slot=7 and slotType='bank'
		
		silverstarwalker@gmail.com: Ranger
		
		update item set name='Shendoma\'s Icy Crescent',
		itemSlot='range',
		type='range',
		damage=47,
		delay=8200,
		rarity=5,
		xPos=-704,
		yPos=-704,
		enhancePhysical=9,
		absorbCold=35,
		leech=13,
		haste=-150,
		globalHaste=-100,
		castingHaste=-100,
		resistCold=117,
		cold=95,
		allStats=15,
		critChance=19,
		critDamage=12,
		enhanceAll=7,
		hp=135,
		req=76,
		flavorText='An exotic weapon from Rorvalen, a plane of frost and sleet ruled by Shendoma.' 
		where email='silverstarwalker@gmail.com' and slot=8 and slotType='bank'
		
		================================================
		email: incurse@gmail.com - emailed
		class: SK		
		
		2h Sword
		######################
		Skill Haste
		Absorb from All Magic
		Life Leech
		All skills
		2h slashing
		Evocation
		Alteration
		Magic Find
		
		update item set name='Indocolite Revenant Thresher',
		itemSlot='weapons',
		type='cleaved',
		damage=95,
		delay=5600,
		rarity=5,
		xPos=-576,
		yPos=-896,
		hp=150,
		sta=42,
		str=55,
		critChance=25,
		critDamage=25,
		physicalDamage=117,
		enhancePhysical=33,
		doubleAttack=15,
		haste=-150,
		globalHaste=-270,
		absorbPoison=5,
		absorbMagic=5,
		absorbLightning=5,
		absorbCold=5,
		absorbFire=5,
		twoHandSlash=12,
		evocation=21,
		alteration=14,
		lightRadius=13,
		req=76,
		proc='Effect: Enervate', 
		flavorText='Engraved with runes of a long forgotten language.' 
		where email='incurse@gmail.com' and slot=8 and slotType='bank'
		
		update item set name='Wailing Death',
		itemSlot='chest',
		type='plate',
		armor=281,
		rarity=5,
		xPos=-256,
		yPos=-960,
		hp=100,
		sta=50,
		hpRegen=12,
		leech=5,
		str=50,
		agi=35,
		dex=44,
		twoHandSlash=12,
		doubleAttack=12,
		haste=-50,
		globalHaste=-50,
		absorbPoison=7,
		absorbMagic=7,
		absorbLightning=7,
		absorbCold=7,
		absorbFire=7,
		defense=13,
		riposte=13,
		allResist=44,
		enhancePhysical=7,
		flavorText='Empowered by forbidden magic with the suffering of tortured souls',
		req=76 
		where email='incurse@gmail.com' and slot=7 and slotType='bank'
		
		Malocciu@gmail.com: Druid DONE
		
		update item set name='Grove Walker\'s Scimitar',
		itemSlot='weapons',
		type='slashed',
		damage=33,
		delay=2600,
		rarity=5,
		xPos=-576,
		yPos=-64,
		str=40,
		sta=40,
		wis=60,
		hp=35,
		mp=125,
		allResist=30,
		allResist=25,
		enhanceLightning=25,
		enhanceCold=15,
		enhanceFire=21,
		critDamage=18,
		critChance=9,
		evocation=15,
		conjuration=24,
		lightRadius=10,
		mpRegen=13,
		req=76,
		proc='Effect: Pungent Fungi', 
		flavorText='Covered in a film of fungal spores, this verdant blade shimmers with natural power.' 
		where email='malocciu@gmail.com' and slot=8 and slotType='bank'
		
		dustin.kikuchi@gmail.com: Shaman DONE
		
		update item set name='Odious Spear of Fate',
		itemSlot='weapons',
		type='pierced',
		damage=33,
		delay=2600,
		rarity=5,
		xPos=-704,
		yPos=-320,
		str=30,
		dex=30,
		sta=30,
		wis=60,
		hp=30,
		mp=70,
		allResist=25,
		enhancePoison=21,
		enhanceCold=15,
		enhancePhysical=15,
		critChance=12,
		mpRegen=5,
		allSkills=5,
		lightRadius=15,
		poisonDamage=66,
		leech=9,
		wraith=15,
		req=76,
		proc='Effect: Odious Plague', 
		flavorText='Crashing into the tides of fate, guided by destiny, our determined hero carves an unlikely path to victory.' 
		where email='dustin.kikuchi@gmail.com' and slot=122 and slotType='bank'
		
		update item set name='Bohemian Phalanx Chains',
		itemSlot='chest',
		type='chain',
		armor=213,
		rarity=5,
		xPos=-256,
		yPos=-512,
		hp=133,
		mp=79,
		allStats=22,
		enhancePoison=5,
		enhanceCold=7,
		enhancePhysical=14,
		critChance=9,
		critDamage=17,
		allResist=38,
		absorbPoison=5,
		absorbMagic=5,
		absorbLightning=5,
		absorbCold=5,
		absorbFire=5,
		phyMit=35,
		silence=55,
		runSpeed=15,
		hpRegen=9,
		mpRegen=12,
		req=76 
		where email='dustin.kikuchi@gmail.com' and slot=121 and slotType='bank'
		
		kcoulter@gmail.com: not sure yet - WAITING APPROVAL
		
		update item set name='Painmurder Mallet',
		itemSlot='weapons',
		type='smashed',
		damage=106,
		delay=6000,
		rarity=5,
		xPos=-640,
		yPos=-896,
		physicalDamage=187,
		allStats=40,
		allSkills=8,
		critChance=20,
		critDamage=30,
		enhancePhysical=35,
		doubleAttack=0,
		haste=-200,
		globalHaste=-200,
		castingHaste=-200,
		absorbPoison=10,
		absorbCold=7,
		twoHandBlunt=15,
		allResist=30,
		lightRadius=13,
		fear=50,
		stun=20,
		req=76,
		proc='Effect: Psychic Blast', 
		flavorText='A splatter of blood are the only remnants of its helpless victims.' 
		where email='kcoulter@gmail.com' and slot=42 and slotType='bank'
		
		update item set name='Hungering Soul Cage',
		itemSlot='chest',
		type='plate',
		armor=280,
		rarity=5,
		xPos=-256,
		yPos=-896,
		hp=90,
		mp=55,
		sta=39,
		str=48,
		enhancePhysical=14,
		critChance=12,
		allResist=33,
		absorbPoison=7,
		absorbMagic=10,
		absorbFire=7,
		magMit=33,
		phyMit=20,
		fear=17,
		stun=17,
		silence=17,
		cold=17,
		riposte=16,
		hpRegen=15,
		mpRegen=7,
		req=76 
		where email='kcoulter@gmail.com' and slot=7 and slotType='bank'
		
		reddragonofwu@hotmail.com: Ranger APPROVE?
		
		update item set name='Falzitherin\'s Claw',
		itemSlot='weapons',
		type='slashed',
		damage=22,
		delay=1700,
		enhancePhysical=16,
		rarity=5,
		xPos=-576,
		yPos=-192,
		allSkills=5,
		haste=-150,
		globalHaste=-250,
		fear=33,
		silence=33,
		leech=12,
		enhanceAll=5,
		critChance=9,
		critDamage=15,
		hp=79,
		goldFind=12,
		wis=55,
		channeling=14,
		poisonDamage=77,
		lightRadius=13, 
		absorbPoison=15, 
		resistPoison=88,
		resistMagic=47,
		req=76,
		proc='Effect: Noxious Vapors', 
		flavorText='The stench of noxious decay emanates forth from the rancid claw of Falzitherin.' 
		where email='reddragonofwu@hotmail.com' and slot=8 and slotType='bank'
		
		theoriginalsportguy@gmail.com: Warrior DONE
		
		update item set name='Executioner\'s Thunderclap',
		itemSlot='weapons',
		type='cleaved',
		damage=96,
		delay=5500,
		rarity=5,
		xPos=-576,
		yPos=-768,
		enhancePhysical=27,
		str=70,
		sta=38,
		dex=55,
		absorbLightning=25,
		stun=20,
		haste=-120,
		globalHaste=-300,
		twoHandSlash=13,
		riposte=17,
		offense=12,
		doubleAttack=20,
		parry=10,
		critChance=32,
		expFind=15,
		leech=15,
		wraith=14,
		resistMagic=33,
		resistLightning=115,
		lightningDamage=117,
		req=76,
		proc='Effect: Thunderclap', 
		flavorText='The crackle of infused lightning bristles within.' 
		where email='ng@test.com' and slot=8 and slotType='bank'
		
		atrius001@gmail.com: Magician staff - pet focused APPROVED???
		
		update item set name='Carbilloth\'s Rainbow Ire',
		itemSlot='weapons',
		type='staff',
		damage=120,
		delay=6600,
		rarity=5,
		xPos=0,
		yPos=-960,
		hp=45,
		mp=135,
		allResist=55,
		absorbPoison=6,
		absorbMagic=6,
		absorbLightning=6,
		absorbCold=6,
		absorbFire=6,
		enhanceAll=10,
		castingHaste=-250,
		silence=35,
		fear=22,
		critDamage=33,
		mpRegen=13,
		hpRegen=5,
		mpKill=30,
		lightRadius=20,
		req=76,
		proc='Effect: Rainbow Hue', 
		flavorText='An ancient staff imbued with the power of visible light.' 
		where email='ng@test.com' and slot=8 and slotType='bank'
		
		coalien@gmx.ch: Shaman - APPROVE??
		
		update item set name='Megnemon\'s Glacial Crook',
		itemSlot='weapons',
		type='staff',
		damage=92,
		delay=5000,
		rarity=5,
		xPos=0,
		yPos=-896,
		hp=75,
		mp=75,
		allResist=32,
		allStats=25,
		enhancePoison=15,
		enhanceCold=25,
		enhancePhysical=13,
		critChance=16,
		critDamage=12,
		mpRegen=8,
		abjuration=15,
		alteration=23,
		twoHandBlunt=14,
		fear=25,
		cold=25,
		stun=25,
		silence=25,
		coldDamage=87,
		leech=9,
		wraith=9,
		req=76,
		proc='Effect: Glacial Spike', 
		flavorText='A powerful relic enchanted by shaman elites exiled from Slagnon.' 
		where email='coalien@gmx.ch' and slot=8 and slotType='bank'
		
		trentjaspar@verizon.net: Paladin...sword and board
		
		update item set name='Heart of Burning Embers',
		itemSlot='weapons',
		type='crushed',
		damage=40,
		delay=3200,
		enhancePhysical=15,
		rarity=5,
		xPos=-640,
		yPos=-512,
		allSkills=8,
		allStats=15,
		haste=-200,
		castingHaste=-200,
		fear=30,
		silence=30,
		stun=30,
		cold=30,
		leech=10,
		mpRegen=6,
		enhanceAll=5,
		critChance=12,
		critDamage=8,
		absorbFire=15,
		allResist=25,
		fireDamage=77,
		lightRadius=15, 
		req=38,
		proc='Effect: Lava Burst', 
		flavorText='Forged in the magma of Ashenflow Peak.' 
		where email='trentjaspar@verizon.net' and slot=38 and slotType='bank'
		
		update item set name='Golem\'s Locket',
		itemSlot='neck',
		type='',
		armor=85,
		hp=75,
		mp=75,
		rarity=5,
		xPos=0,
		yPos=-128,
		allSkills=5,
		allStats=20,
		globalHaste=-80,
		castingHaste=-120,
		fear=45,
		stun=20,
		hpRegen=10,
		mpRegen=12,
		resistLightning=88,
		resistCold=25,
		resistMagic=33,
		resistPoison=50,
		enhancePhysical=7,
		enhanceCold=15,
		enhanceMagic=7,
		enhancePoison=15,
		critChance=10,
		absorbLightning=25,
		absorbCold=12,
		runSpeed=15,
		expFind=12, 
		req=38
		where email='trentjaspar@verizon.net' and slot=39 and slotType='bank'
		
		pharmakos:
		
		update item set name='Sanctified Gavel of Pharmakos',
		itemSlot='weapons',
		type='smashed',
		damage=99,
		delay=5500,
		enhancePhysical=20,
		rarity=5,
		xPos=-640,
		yPos=-960,
		enhanceAll=10,
		critChance=30,
		allSkills=12,
		str=64,
		sta=95,
		dex=52,
		haste=-350,
		globalHaste=-240,
		fear=50,
		silence=50,
		stun=50,
		cold=50,
		leech=20,
		mpRegen=12,
		absorbMagic=25,
		allResist=50,
		magicDamage=235,
		expFind=25, 
		req=76,
		proc='Effect: Kelpie Haze', 
		flavorText='A one-of-a-kind sanctified version of the popular mass produced gavel known for its popular magical effect.' 
		where email='charles.hundersmarck@gmail.com' and slot=46 and slotType='bank'
		
		vitality1337@gmail.com : Paladin - NOT SURE
		
		Weapon Name: Pillar of the Gods
		Art: Golden Corinthian Pillar
		Two Hand Blunt
		Max Possible dmg/delay ratio (sacrifice as many stats as needed)
		Proc: Rebuke (very often)
		Modify Upgrade slots to maximum possible quantity (0/100)
		"This weapon is socketed and can hold a trinket"
		
		cmullers@net1plus.com: Rogue - emailed
		
		tnhhook@gmail.com: emailed
		
		bigdawe@gmail.com - NOT SURE
		
		SELECT * FROM `item` where slotType='bank' and name='' and email='peter.j.ferro@gmail.com' and hardcoreMode='false';
		Maelfyn's Infinite Loop
		// CHECK HARDCORE AND SOFTCORE
		update item set name='Maelfyn\'s Infinite Loop',
		itemSlot='ring',
		type='',
		rarity=3,
		xPos=0,
		yPos=-512,
		hp=50,
		leech=5,
		wraith=5,
		allResist=15,
		allStats=15,
		critChance=5,
		enhanceAll=3,
		cold=15,
		fear=15,
		stun=15,
		silence=15,
		flavorText="Rewarded for exemplary assistance with the wiki.",
		req=24
		where email='peter.j.ferro@gmail.com' and slot=8 and slotType='bank' and hardcoreMode='true'
		
		// award set item
		update item set name="Friar's Epiphany",
		itemSlot='gloves',
		type='leather',
		rarity=4,
		armor=65,
		xPos=-384,
		yPos=-256,
		quality=1,
		riposte=4,
		critChance=6,
		critDamage=15,
		resistMagic=50,
		resistFire=25,
		leech=10,
		haste=-130,
		globalHaste=-50,
		req=46 where email='jerald655@yahoo.com' and slot=68 and slotType='bank' and hardcoreMode='false';
		
		update item set name="Friar's Gift",
		itemSlot='belt',
		type='leather',
		rarity=4,
		armor=42,
		xPos=-448,
		yPos=-192,
		quality=1,
		resistLightning=15,
		resistMagic=30,
		globalHaste=-150,
		dex=19,
		critChance=5,
		offense=4,
		req=45 where email='jerald655@yahoo.com' and slot=69 and slotType='bank' and hardcoreMode='false';
		
		// reward unique item
		update item set name="Vampire Cowl",
		itemSlot='helmet',
		type='cloth',
		rarity=3,
		armor=23,
		xPos=-64,
		yPos=0,
		quality=0,
		coldDamage=5,
		sta=19,
		leech=3,
		wraith=3,
		phyMit=2,
		magMit=2,
		flavorText='This vampiric relic is a favorite amongst the cold-blooded harbingers that wander the depths of Viston\'s Redoubt.',
		req=36 where email='peter.j.ferro@gmail.com' and slot=5 and slotType='bank' and hardcoreMode='true';
		
		// reward set item
		update item set name="Warlock's Nightmare",
		itemSlot='boots',
		type='cloth',
		rarity=4,
		armor=64,
		xPos=-448,
		yPos=-576,
		quality=2,
		stun=50,
		silence=25,
		runSpeed=35,
		resistPoison=65,
		resistMagic=30,
		resistFire=55,
		resistCold=15,
		lightRadius=20,
		expFind=20,
		enhancedArmor=120,
		enhanceAll=3,
		critDamage=27,
		conjuration=12,
		allStats=12,
		req=65 where email='jerald655@yahoo.com' and slot=5 and slotType='bank' and hardcoreMode='false';
		
		// legendary rewards:
		
		update item set name='Golem\'s Locket',
		itemSlot='neck',
		type='',
		armor=85,
		hp=75,
		mp=75,
		rarity=5,
		xPos=0,
		yPos=-128,
		allSkills=5,
		allStats=20,
		globalHaste=-80,
		castingHaste=-120,
		fear=45,
		stun=20,
		hpRegen=10,
		mpRegen=12,
		resistLightning=88,
		resistCold=25,
		resistMagic=33,
		resistPoison=50,
		enhancePhysical=7,
		enhanceCold=15,
		enhanceMagic=7,
		enhancePoison=15,
		critChance=10,
		absorbLightning=25,
		absorbCold=12,
		runSpeed=15,
		expFind=12, 
		req=76
		where email='deel0410@yahoo.com' and slot=8 and slotType='bank'
		
		
			update item set name='Kickstarter Ring',
				itemSlot='ring',
				rarity=3,
				xPos=0,
				yPos=-512,
				allStats=7,
				globalHaste=-70,
				castingHaste=-70,
				fear=12,
				cold=12,
				stun=12,
				silence=12,
				expFind=5,
				goldFind=12,
				flavorText='\"Thank you for your supporting the campaign.\" Maelfyn Sinifay', 
				lightRadius=10 where
				email='kneeyul@gmail.com' and slot=2 and slotType='bank';
				
				
			update item set name='Kickstarter Trinket',
				itemSlot='range',
				rarity=3,
				xPos=-768,
				yPos=-960,
				hp=25,
				mp=25,
				hpRegen=5,
				mpRegen=5,
				flavorText='\"Thank you for your supporting the campaign.\" Maelfyn Sinifay', 
				allSkills=2,
				allResist=12 where
				email='kneeyul@gmail.com' and slot=3 and slotType='bank';
		
		// cool names
		
		The Blood-drinker
		Colliding Hymn
		
		select * from item where slotType='bank' and email='kneeyul@gmail.com' and name='' and slot<=3 order by slot;
		// exec('mysqldump nevergri_ngLocal > /home/nevergrind2/public_html/backup_'.$today.'.sql');
?>